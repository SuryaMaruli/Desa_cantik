<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        return view('auth.login');
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


        $user = User::where('email', $credentials['email'])->first();

        if ($user) {
            $storedPassword = (string) $user->password;
            $plainInput = (string) $credentials['password'];

            // Deteksi apakah password tersimpan adalah hash valid
            $passwordInfo = password_get_info($storedPassword);
            $isHashed = !empty($passwordInfo['algo']);

            $isValid = false;

            if ($isHashed) {
                // Password sudah hash (bcrypt/argon), verifikasi normal
                $isValid = Hash::check($plainInput, $storedPassword);
            } else {
                // Password plaintext di DB: cocokkan langsung lalu upgrade ke bcrypt
                $isValid = hash_equals($storedPassword, $plainInput);

                if ($isValid) {
                    $user->password = Hash::make($plainInput);
                    $user->save();
                }
            }

            if ($isValid) {
                Auth::login($user, $request->filled('remember'));
                $request->session()->regenerate();

                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Login berhasil! Selamat datang kembali, ' . Auth::user()->name);
            }
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
