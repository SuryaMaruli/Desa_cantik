<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Show the login form
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // Create dummy user if not exists
        $this->createDummyUser();
        
        return view('auth.login');
    }

    /**
     * Create a dummy user for testing
     */
    private function createDummyUser()
    {
        // Check if dummy user already exists
        if (!User::where('email', 'admin@citangkil.id')->exists()) {
            User::create([
                'name' => 'Admin Citangkil',
                'email' => 'admin@citangkil.id',
                'password' => bcrypt('password123'),
                'role' => 'admin'
            ]);
        }
    }

    /**
     * Handle a login request to the application
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate the form data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Check for dummy user credentials
        if ($credentials['email'] === 'admin@citangkil.id') {
            $this->createDummyUser();
        }

        // Attempt to log the user in
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                           ->with('success', 'Login berhasil! Selamat datang kembali, ' . Auth::user()->name);
        }

        // If login fails
        throw ValidationException::withMessages([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    /**
     * Log the user out of the application
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'Anda telah berhasil keluar.');
    }
}
