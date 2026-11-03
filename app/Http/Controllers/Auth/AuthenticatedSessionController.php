<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    $user = auth()->user();
    $intendedRole = $request->input('role');

    // Admins may sign in from either login page.
    if (! $user->isAdmin() && $intendedRole && $user->role !== $intendedRole) {
        Auth::logout();

        $accountType = $intendedRole === 'vet' ? 'Veterinarian' : 'Pet Owner';

        return back()->withErrors([
            'email' => 'This account is not registered as a ' . $accountType . '.',
        ]);
    }

    // Vets must be approved by an admin before they can log in.
    if ($user->role === 'vet') {
        $status = $user->vetProfile()->value('approval_status');

        if ($status !== 'approved') {
            Auth::logout();

            return back()->withErrors([
                'email' => $status === 'rejected'
                    ? 'Your application was not approved. Please contact the administrator.'
                    : 'Your application is awaiting administrator approval.',
            ]);
        }
    }

    return redirect()->route($user->dashboardRouteName());
}
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
