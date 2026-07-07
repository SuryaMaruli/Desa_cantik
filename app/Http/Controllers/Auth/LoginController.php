<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Village;

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

                return redirect()->intended($this->adminDashboardUrlFor($user))
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
        $user = Auth::user();
        $redirectTo = $this->homeUrlForLogout($request, $user);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($redirectTo)->with('status', 'Anda telah berhasil keluar.');
    }

    private function adminDashboardUrlFor(User $user): string
    {
        if ($user->role !== 'admin') {
            return '/admin/dashboard';
        }

        $village = $user->village_id ? Village::find($user->village_id) : null;

        return $village ? '/admin/' . $village->slug . '/dashboard' : '/admin/dashboard';
    }
    private function homeUrlForLogout(Request $request, ?User $user): string
    {
        $defaultSlug = config('villages.default');
        $villages = config('villages.items', []);
        $slug = $request->input('village');

        if (!$slug && app()->bound('currentVillageSlug')) {
            $slug = app('currentVillageSlug');
        }

        $slug = is_string($slug) && array_key_exists($slug, $villages) ? $slug : null;
        $slug = $slug === $defaultSlug ? null : $slug;

        if (!$slug && $user && $user->role !== 'super_admin') {
            $village = $user->village_id
                ? Village::find($user->village_id)
                : Village::where('is_default', true)->first();

            $slug = $village?->slug;
        }

        if (!$slug && $user?->role === 'super_admin') {
            $slug = $request->session()->get('admin_active_village');
        }

        if (!$slug || $slug === $defaultSlug || !array_key_exists($slug, $villages)) {
            return '/';
        }

        return '/' . $slug;
    }
}
