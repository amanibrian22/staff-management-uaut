<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\RiskResponseNotification;
use Illuminate\Support\Facades\Log;

class RiskController extends Controller
{
    public function showStaffDashboard()
    {
        $risks = Risk::where('reported_by', Auth::id())
                     ->with(['reporter', 'responder'])
                     ->get();
        Log::info('Staff dashboard loaded', [
            'user_id' => Auth::id(),
            'risk_count' => $risks->count(),
            'risks' => $risks->map(function ($risk) {
                return [
                    'id' => $risk->id,
                    'responded_by' => $risk->responded_by,
                    'responder_name' => $risk->responder ? $risk->responder->name : null,
                ];
            })->toArray(),
        ]);
        return view('staff.staff', compact('risks'));
    }

    public function showTechnicalDashboard()
    {
        $risks = Risk::where('type', 'technical')->with(['reporter', 'responder'])->get();
        return view('staff.technical', compact('risks'));
    }

    public function showFinancialDashboard()
    {
        $risks = Risk::where('type', 'financial')->with(['reporter', 'responder'])->get();
        return view('staff.financial', compact('risks'));
    }

    public function showAcademicDashboard()
    {
        $risks = Risk::where('type', 'academic')->with(['reporter', 'responder'])->get();
        return view('staff.academic', compact('risks'));
    }

    public function showAdminDashboard(Request $request)
    {
        $riskQuery = Risk::query()->with(['reporter', 'responder']);

        if ($request->filled('type')) {
            $riskQuery->where('type', $request->input('type'));
        }

        if ($request->filled('urgency')) {
            $riskQuery->where('urgency', $request->input('urgency'));
        }

        if ($request->filled('status')) {
            $riskQuery->where('status', $request->input('status'));
        }

        $risks = $riskQuery->paginate(10);

        $userQuery = User::query();

        if ($request->filled('role')) {
            $userQuery->where('role', $request->input('role'));
        }

        $users = $userQuery->get();

        $metrics = $this->getRiskMetrics($request);

        return view('staff.admin', compact('risks', 'users', 'metrics'));
    }

    public function filterRisks(Request $request)
    {
        try {
            $riskQuery = Risk::query()->with(['reporter', 'responder']);

            if ($request->filled('type')) {
                $riskQuery->where('type', $request->input('type'));
            }

            if ($request->filled('urgency')) {
                $riskQuery->where('urgency', $request->input('urgency'));
            }

            if ($request->filled('status')) {
                $riskQuery->where('status', $request->input('status'));
            }

            $risks = $riskQuery->paginate(10);

            if (!View::exists('staff.partials.risks-table')) {
                return response()->json(['error' => 'View staff.partials.risks-table not found'], 404);
            }

            $tableHtml = view('staff.partials.risks-table', compact('risks'))->render();
            $paginationHtml = $risks->appends($request->query())->links('pagination::tailwind')->toHtml();

            return response()->json([
                'table' => $tableHtml,
                'pagination' => $paginationHtml,
                'total' => $risks->total(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error filtering risks: ' . $e->getMessage());
            return response()->json(['error' => 'Error filtering risks: ' . $e->getMessage()], 500);
        }
    }

    public function filterUsers(Request $request)
    {
        try {
            $userQuery = User::query();

            if ($request->filled('role')) {
                $userQuery->where('role', $request->input('role'));
            }

            $users = $userQuery->get();

            if (!View::exists('staff.partials.users-table')) {
                return response()->json(['error' => 'View staff.partials.users-table not found'], 404);
            }

            $tableHtml = view('staff.partials.users-table', compact('users'))->render();

            return response()->json([
                'table' => $tableHtml,
                'total' => $users->count(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error filtering users: ' . $e->getMessage());
            return response()->json(['error' => 'Error filtering users: ' . $e->getMessage()], 500);
        }
    }

    public function reportRisk(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:1000',
            'type' => 'required|in:technical,financial,academic',
            'urgency' => 'required|in:low,medium,high',
        ]);

        $risk = Risk::create([
            'reported_by' => Auth::id(),
            'description' => $validated['description'],
            'type' => $validated['type'],
            'urgency' => $validated['urgency'],
            'status' => 'pending',
        ]);

        Log::info('Risk reported', [
            'risk_id' => $risk->id,
            'reported_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Risk reported successfully.');
    }

    public function reportProgress(Request $request, Risk $risk)
    {
        $validated = $request->validate([
            'response' => 'required|string|max:1000',
        ]);

        $updated = $risk->update([
            'response' => $validated['response'],
            'status' => 'in_progress',
            'responded_by' => Auth::id(),
        ]);

        Log::info('Risk progress reported', [
            'risk_id' => $risk->id,
            'responded_by' => Auth::id(),
            'updated' => $updated,
            'user' => Auth::user()->toArray(),
        ]);

        $this->sendNotification($risk, 'progress reported');

        return redirect()->back()->with('success', 'Progress reported successfully.');
    }

    public function resolveRisk(Request $request, Risk $risk)
    {
        $validated = $request->validate([
            'response' => 'required|string|max:1000',
        ]);

        if (!Auth::check()) {
            Log::error('No authenticated user found in resolveRisk', ['risk_id' => $risk->id]);
            return redirect()->back()->with('error', 'Authentication required to resolve risk.');
        }

        $updated = $risk->update([
            'response' => $validated['response'],
            'status' => 'resolved',
            'responded_by' => Auth::id(),
        ]);

        Log::info('Risk resolved', [
            'risk_id' => $risk->id,
            'responded_by' => Auth::id(),
            'updated' => $updated,
            'user' => Auth::user()->toArray(),
            'risk_after_update' => $risk->fresh()->toArray(),
        ]);

        if (!$updated) {
            Log::error('Failed to update risk with responded_by', [
                'risk_id' => $risk->id,
                'responded_by' => Auth::id(),
            ]);
        }

        $this->sendNotification($risk, 'resolved');

        return redirect()->back()->with('success', 'Risk resolved successfully.');
    }

    public function suggestAlternate(Request $request, Risk $risk)
    {
        $validated = $request->validate([
            'response' => 'required|string|max:1000',
        ]);

        $updated = $risk->update([
            'response' => $validated['response'],
            'status' => 'unresolved',
            'responded_by' => Auth::id(),
        ]);

        Log::info('Alternate solution suggested', [
            'risk_id' => $risk->id,
            'responded_by' => Auth::id(),
            'updated' => $updated,
            'user' => Auth::user()->toArray(),
        ]);

        $this->sendNotification($risk, 'alternate solution suggested');

        return redirect()->back()->with('success', 'Alternate solution suggested successfully.');
    }

    protected function sendNotification(Risk $risk, string $action)
    {
        $reporter = User::find($risk->reported_by);
        if ($reporter && $reporter->email) {
            try {
                Mail::to($reporter->email)->queue(new RiskResponseNotification($risk->fresh()->load(['reporter', 'responder']), $action));
                Log::info('Email notification queued', [
                    'risk_id' => $risk->id,
                    'to' => $reporter->email,
                    'action' => $action,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to queue email notification', [
                    'risk_id' => $risk->id,
                    'to' => $reporter->email,
                    'error' => $e->getMessage(),
                ]);
            }
        } else {
            Log::warning('No valid reporter email found', [
                'risk_id' => $risk->id,
                'reported_by' => $risk->reported_by,
            ]);
        }
    }

    public function adminAddRisk(Request $request)
    {
        $validated = $request->validate([
            'reported_by' => 'required|exists:users,id',
            'description' => 'required|string|max:1000',
            'type' => 'required|in:technical,financial,academic',
            'urgency' => 'required|in:low,medium,high',
        ]);

        Risk::create([
            'reported_by' => $validated['reported_by'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'urgency' => $validated['urgency'],
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Risk added successfully.');
    }

    public function adminEditRisk(Request $request, Risk $risk)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:1000',
            'type' => 'required|in:technical,financial,academic',
            'urgency' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,resolved,unresolved',
            'response' => 'nullable|string|max:1000',
            'responded_by' => 'nullable|exists:users,id',
        ]);

        $risk->update($validated);

        return redirect()->back()->with('success', 'Risk updated successfully.');
    }

    public function adminDeleteRisk(Risk $risk)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $risk->delete();
        return redirect()->back()->with('success', 'Risk deleted successfully.');
    }

    public function adminAddUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'role' => 'required|in:staff,technical,financial,academic',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->back()->with('success', 'User added successfully.');
    }

    public function adminEditUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'role' => 'required|in:staff,technical,financial,academic',
            'password' => 'nullable|string|min:8',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
        ]);

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function adminDeleteUser(User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Cannot delete your own account.');
        }

        Risk::where('reported_by', $user->id)->delete();
        $user->delete();

        return redirect()->back()->with('success', 'User and associated risks deleted successfully.');
    }

    protected function getRiskMetrics(Request $request)
    {
        $query = Risk::query();

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('urgency')) {
            $query->where('urgency', $request->input('urgency'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $total_risks = $query->count();
        $resolved_risks = $query->clone()->where('status', 'resolved')->count();
        $pending_risks = $query->clone()->where('status', 'pending')->count();
        $in_progress_risks = $query->clone()->where('status', 'in_progress')->count();
        $unresolved_risks = $query->clone()->where('status', 'unresolved')->count();
        $by_department = $query->clone()->groupBy('type')->selectRaw('type, count(*) as count')->pluck('count', 'type')->toArray();
        $by_urgency = $query->clone()->groupBy('urgency')->selectRaw('urgency, count(*) as count')->pluck('count', 'urgency')->toArray();

        return compact(
            'total_risks',
            'resolved_risks',
            'pending_risks',
            'in_progress_risks',
            'unresolved_risks',
            'by_department',
            'by_urgency'
        );
    }

    public function generateReport(Request $request)
    {
        try {
            $riskQuery = Risk::query()->with(['reporter', 'responder']);

            if ($request->filled('type')) {
                $riskQuery->where('type', $request->input('type'));
            }

            if ($request->filled('urgency')) {
                $riskQuery->where('urgency', $request->input('urgency'));
            }

            if ($request->filled('status')) {
                $riskQuery->where('status', $request->input('status'));
            }

            $risks = $riskQuery->get();
            $metrics = $this->getRiskMetrics($request);

            $pdf = Pdf::loadView('reports.risk-report', compact('risks', 'metrics'));
            return $pdf->download('risk_management_report.pdf');
        } catch (\Exception $e) {
            Log::error('Report generation error', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error generating report: ' . $e->getMessage());
        }
    }

    public function debugRisksTable()
    {
        $risks = Risk::with(['reporter', 'responder'])->paginate(10);
        if (!View::exists('staff.partials.risks-table')) {
            return response()->json(['error' => 'View staff.partials.risks-table not found'], 404);
        }
        return view('staff.partials.risks-table', compact('risks'));
    }
}
