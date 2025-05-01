<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Risk;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RiskController extends Controller
{
    // Existing methods remain unchanged...

    public function showStaffDashboard()
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized');
        }
        $reportedRisks = Risk::where('reported_by', Auth::id())->latest()->get();
        return view('staff.staff', compact('reportedRisks'));
    }

    public function reportRisk(Request $request)
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'description' => 'required|string',
            'type' => 'required|in:technical,financial,academic',
        ]);

        Risk::create([
            'reported_by' => Auth::id(),
            'description' => $request->description,
            'type' => $request->type,
            'status' => 'pending',
        ]);

        return redirect()->route('staff.dashboard')->with('success', 'Risk reported successfully!');
    }

    public function showTechnicalDashboard()
    {
        if (Auth::user()->role !== 'technical') {
            abort(403, 'Unauthorized');
        }
        $risks = Risk::where('type', 'technical')->latest()->with('reporter')->get();
        return view('staff.technical', compact('risks'));
    }

    public function showFinancialDashboard()
    {
        if (Auth::user()->role !== 'financial') {
            abort(403, 'Unauthorized');
        }
        $risks = Risk::where('type', 'financial')->latest()->with('reporter')->get();
        return view('staff.financial', compact('risks'));
    }

    public function showAcademicDashboard()
    {
        if (Auth::user()->role !== 'academic') {
            abort(403, 'Unauthorized');
        }
        $risks = Risk::where('type', 'academic')->latest()->with('reporter')->get();
        return view('staff.academic', compact('risks'));
    }

    public function resolveRisk(Request $request, Risk $risk)
    {
        if (!in_array(Auth::user()->role, ['technical', 'financial', 'academic']) || $risk->type !== Auth::user()->role) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'response' => 'required|string',
        ]);

        $risk->update([
            'status' => 'resolved',
            'response' => $request->response,
        ]);

        return redirect()->back()->with('success', 'Risk resolved successfully!');
    }

    // Admin Dashboard
    public function showAdminDashboard()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $risks = Risk::with('reporter')->latest()->get();
        $users = User::whereIn('role', ['staff', 'technical', 'financial', 'academic'])->get(); // For user management
        return view('staff.admin', compact('risks', 'users'));
    }

    // Admin Add Risk
    public function adminAddRisk(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'reported_by' => 'required|exists:users,id',
            'description' => 'required|string',
            'type' => 'required|in:technical,financial,academic',
        ]);

        Risk::create([
            'reported_by' => $request->reported_by,
            'description' => $request->description,
            'type' => $request->type,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Risk added successfully!');
    }

    // Admin Edit Risk
    public function adminEditRisk(Request $request, Risk $risk)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'description' => 'required|string',
            'type' => 'required|in:technical,financial,academic',
            'status' => 'required|in:pending,resolved',
            'response' => 'nullable|string',
        ]);

        $risk->update([
            'description' => $request->description,
            'type' => $request->type,
            'status' => $request->status,
            'response' => $request->response,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Risk updated successfully!');
    }

    // Admin Delete Risk
    public function adminDeleteRisk(Risk $risk)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $risk->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Risk deleted successfully!');
    }

    // Admin Add User
    public function adminAddUser(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
            'role' => 'required|in:staff,technical,financial,academic',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User added successfully!');
    }
}