<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->isMethod('get')) {
            return $this->showLoginForm();
        }

        if ($request->isMethod('post')) {
            return $this->login($request);
        }

        return redirect()->route('staff.login');
    }

    protected function showLoginForm()
    {
        return view('auth.login');
    }

    protected function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        Log::info('Attempting login with email: ' . $request->email);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $role = $user->role;

            Log::info('User logged in: ' . $user->email . ', Role: ' . $role);

            $redirectRoute = match ($role) {
                'staff' => 'staff.dashboard',
                'technical' => 'technical.dashboard',
                'financial' => 'financial.dashboard',
                'academic' => 'academic.dashboard',
                'admin' => 'admin.dashboard', // Added admin redirect
                default => 'staff.dashboard',
            };

            Log::info('Redirecting to route: ' . $redirectRoute);

            return redirect()->route($redirectRoute);
        }

        Log::warning('Login failed for email: ' . $request->email);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('staff.login');
    }
}