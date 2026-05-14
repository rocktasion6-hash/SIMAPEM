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

       // Ambil user yang baru saja login
        $user = $request->user();

        // Redirect berdasarkan role
        if ($user->role->value === 'warga') {
            return redirect()->route('warga.complaints.index');
        } elseif ($user->role->value === 'front_office') {   
            return redirect()->route('fo.verifikasi.index');
        } elseif ($user->role->value === 'kasi') {
            return redirect()->route('kasi.assignment.index');
        } elseif ($user->role->value === 'pelaksana') {
            return redirect()->route('pelaksana.tasks.index');
        } elseif ($user->role->value === 'kadis') {
            return redirect()->route('kadis.dashboard');
        }   
        return redirect()->intended(route('login'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }
}
