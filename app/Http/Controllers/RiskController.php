<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RiskController extends Controller
{
    public function showStaffDashboard()
    {
        $risks = Risk::where('reported_by', Auth::id())->get();
        return view('staff.staff', compact('risks'));
    }

    public function showTechnicalDashboard()
    {
        $risks = Risk::where('type', 'technical')->get();
        return view('staff.technical', compact('risks'));
    }

    public function showFinancialDashboard()
    {
        $risks = Risk::where('type', 'financial')->get();
        return view('staff.financial', compact('risks'));
    }

    public function showAcademicDashboard()
    {
        $risks = Risk::where('type', 'academic')->get();
        return view('staff.academic', compact('risks'));
    }

    public function showAdminDashboard()
    {
        $risks = Risk::all();
        $users = User::all();
        $metrics = $this->getRiskMetrics();
        return view('staff.admin', compact('risks', 'users', 'metrics'));
    }

    public function reportRisk(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:1000',
            'type' => 'required|in:technical,financial,academic',
            'urgency' => 'required|in:low,medium,high',
        ]);

        Risk::create([
            'reported_by' => Auth::id(),
            'description' => $validated['description'],
            'type' => $validated['type'],
            'urgency' => $validated['urgency'],
            'status' => 'pending',
        ]);

        return redirect()->route('staff.dashboard')->with('success', 'Risk reported successfully!');
    }

    public function reportProgress(Request $request, Risk $risk)
    {
        $validated = $request->validate([
            'response' => 'required|string|max:1000',
        ]);

        $risk->update([
            'response' => $validated['response'],
            'status' => 'in_progress',
            'responder_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Progress reported successfully!');
    }

    public function resolveRisk(Request $request, Risk $risk)
    {
        $validated = $request->validate([
            'response' => 'required|string|max:1000',
        ]);

        $risk->update([
            'response' => $validated['response'],
            'status' => 'resolved',
            'responder_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Risk resolved successfully!');
    }

    public function suggestAlternate(Request $request, Risk $risk)
    {
        $validated = $request->validate([
            'response' => 'required|string|max:1000',
        ]);

        $risk->update([
            'response' => $validated['response'],
            'status' => 'unresolved',
            'responder_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Alternate solution suggested successfully!');
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

        return redirect()->route('admin.dashboard')->with('success', 'Risk added successfully!');
    }

    public function adminEditRisk(Request $request, Risk $risk)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:1000',
            'type' => 'required|in:technical,financial,academic',
            'urgency' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,resolved,unresolved',
            'response' => 'nullable|string|max:1000',
        ]);

        $risk->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Risk updated successfully!');
    }

    public function adminDeleteRisk(Risk $risk)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $risk->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Risk deleted successfully!');
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

        return redirect()->route('admin.dashboard')->with('success', 'User added successfully!');
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

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully!');
    }

    public function adminDeleteUser(User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Prevent deleting the current admin user
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.dashboard')->with('error', 'Cannot delete your own account!');
        }

        // Delete all risks reported by the user
        Risk::where('reported_by', $user->id)->delete();

        // Delete the user
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User and associated risks deleted successfully!');
    }

    protected function getRiskMetrics()
    {
        $total_risks = Risk::count();
        $resolved_risks = Risk::where('status', 'resolved')->count();
        $pending_risks = Risk::where('status', 'pending')->count();
        $in_progress_risks = Risk::where('status', 'in_progress')->count();
        $unresolved_risks = Risk::where('status', 'unresolved')->count();
        $by_department = Risk::groupBy('type')->selectRaw('type, count(*) as count')->pluck('count', 'type')->toArray();
        $by_urgency = Risk::groupBy('urgency')->selectRaw('urgency, count(*) as count')->pluck('count', 'urgency')->toArray();

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

    public function generateReport()
    {
        $risks = Risk::all();
        $metrics = $this->getRiskMetrics();

        $latex = "\\documentclass{article}\n";
        $latex .= "\\usepackage{geometry}\n";
        $latex .= "\\geometry{a4paper, margin=1in}\n";
        $latex .= "\\usepackage{booktabs}\n";
        $latex .= "\\usepackage{longtable}\n";
        $latex .= "\\usepackage{pdflscape}\n";
        $latex .= "\\title{Risk Management Report}\n";
        $latex .= "\\author{UAUT Risk Management System}\n";
        $latex .= "\\date{\\today}\n";
        $latex .= "\\begin{document}\n";
        $latex .= "\\maketitle\n";
        $latex .= "\\section{Summary Metrics}\n";
        $latex .= "\\begin{tabular}{lr}\n";
        $latex .= "\\toprule\n";
        $latex .= "Metric & Count \\\\\n";
        $latex .= "\\midrule\n";
        $latex .= "Total Risks & {$metrics['total_risks']} \\\\\n";
        $latex .= "Resolved Risks & {$metrics['resolved_risks']} \\\\\n";
        $latex .= "Pending Risks & {$metrics['pending_risks']} \\\\\n";
        $latex .= "In Progress Risks & {$metrics['in_progress_risks']} \\\\\n";
        $latex .= "Unresolved Risks & {$metrics['unresolved_risks']} \\\\\n";
        $latex .= "\\bottomrule\n";
        $latex .= "\\end{tabular}\n";
        $latex .= "\\section{Risks by Department}\n";
        $latex .= "\\begin{tabular}{lr}\n";
        $latex .= "\\toprule\n";
        $latex .= "Department & Count \\\\\n";
        $latex .= "\\midrule\n";
        foreach ($metrics['by_department'] as $dept => $count) {
            $latex .= ucfirst($dept) . " & {$count} \\\\\n";
        }
        $latex .= "\\bottomrule\n";
        $latex .= "\\end{tabular}\n";
        $latex .= "\\section{Risks by Urgency}\n";
        $latex .= "\\begin{tabular}{lr}\n";
        $latex .= "\\toprule\n";
        $latex .= "Urgency & Count \\\\\n";
        $latex .= "\\midrule\n";
        foreach ($metrics['by_urgency'] as $urgency => $count) {
            $latex .= ucfirst($urgency) . " & {$count} \\\\\n";
        }
        $latex .= "\\bottomrule\n";
        $latex .= "\\end{tabular}\n";
        $latex .= "\\section{All Risks}\n";
        $latex .= "\\begin{landscape}\n";
        $latex .= "\\begin{longtable}{p{3cm}p{5cm}p{2cm}p{2cm}p{2cm}p{5cm}p{3cm}}\n";
        $latex .= "\\toprule\n";
        $latex .= "Reported By & Description & Type & Urgency & Status & Response & Responder \\\\\n";
        $latex .= "\\midrule\n";
        foreach ($risks as $risk) {
            $reportedBy = addslashes($risk->reporter->name ?? 'Unknown');
            $description = addslashes(Str::limit($risk->description, 100));
            $type = ucfirst($risk->type);
            $urgency = ucfirst($risk->urgency);
            $status = ucfirst(str_replace('_', ' ', $risk->status));
            $response = addslashes($risk->response ?? 'None');
            $responder = addslashes($risk->responder ? $risk->responder->name : 'None');
            $latex .= "{$reportedBy} & {$description} & {$type} & {$urgency} & {$status} & {$response} & {$responder} \\\\\n";
        }
        $latex .= "\\bottomrule\n";
        $latex .= "\\end{longtable}\n";
        $latex .= "\\end{landscape}\n";
        $latex .= "\\end{document}\n";

        $tempDir = storage_path('app/reports');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }
        $texFile = $tempDir . '/report.tex';
        file_put_contents($texFile, $latex);

        $outputDir = $tempDir . '/output';
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        $command = "latexmk -pdf -outdir={$outputDir} {$texFile} 2>&1";
        $output = [];
        $returnVar = 0;
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            return redirect()->route('admin.dashboard')->with('error', 'Failed to generate report: ' . implode(' ', $output));
        }

        $pdfFile = $outputDir . '/report.pdf';
        if (!file_exists($pdfFile)) {
            return redirect()->route('admin.dashboard')->with('error', 'PDF file was not generated.');
        }

        return response()->download($pdfFile, 'risk_management_report.pdf')->deleteFileAfterSend(true);
    }
}