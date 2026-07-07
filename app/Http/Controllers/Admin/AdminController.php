<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->role === 'super_admin', 403, 'Hanya super admin yang dapat mengelola admin.');

        $admins = User::with('village')->orderBy('created_at', 'desc')->paginate(10);
        $isSuperAdmin = true;

        return view('admin.admin.index', compact('admins', 'isSuperAdmin'));
    }

    public function create()
    {
        abort_unless(auth()->user()->role === 'super_admin', 403, 'Hanya super admin yang dapat membuat admin.');

        $isSuperAdmin = true;
        $villages = Village::orderBy('official_name')->get();

        return view('admin.admin.create', compact('isSuperAdmin', 'villages'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->role === 'super_admin', 403, 'Hanya super admin yang dapat membuat admin.');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:super_admin,admin',
            'village_id' => [
                Rule::requiredIf($request->input('role') === 'admin'),
                'nullable',
                'exists:villages,id',
            ],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'village_id' => $validated['role'] === 'admin' ? $validated['village_id'] : null,
        ]);

        return redirect()->route('admin.admin.index')
            ->with('success', 'Admin berhasil ditambahkan');
    }

    public function edit(User $admin)
    {
        abort_unless(auth()->user()->role === 'super_admin', 403, 'Hanya super admin yang dapat mengubah admin.');

        $isSuperAdmin = true;
        $isEditingSelf = auth()->id() === $admin->id;
        $canChangeRole = !$isEditingSelf;
        $villages = Village::orderBy('official_name')->get();

        return view('admin.admin.edit', compact('admin', 'isSuperAdmin', 'canChangeRole', 'villages'));
    }

    public function update(Request $request, User $admin)
    {
        abort_unless(auth()->user()->role === 'super_admin', 403, 'Hanya super admin yang dapat mengubah admin.');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'role' => 'required|in:super_admin,admin',
            'village_id' => [
                Rule::requiredIf($request->input('role') === 'admin'),
                'nullable',
                'exists:villages,id',
            ],
        ]);

        $isEditingSelf = auth()->id() === $admin->id;
        if ($isEditingSelf && $admin->role === 'super_admin' && $validated['role'] === 'admin') {
            return redirect()->route('admin.admin.index')
                ->with('error', 'Super admin tidak dapat mengubah role nya sendiri menjadi admin');
        }

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'village_id' => $validated['role'] === 'admin' ? $validated['village_id'] : null,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.admin.index')
            ->with('success', 'Data admin berhasil diperbarui');
    }

    public function destroy(User $admin)
    {
        abort_unless(auth()->user()->role === 'super_admin', 403, 'Hanya super admin yang dapat menghapus admin.');

        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.admin.index')
                ->with('error', 'Tidak dapat menghapus akun yang sedang digunakan');
        }

        if ($admin->role === 'super_admin') {
            return redirect()->route('admin.admin.index')
                ->with('error', 'Super admin tidak dapat menghapus super admin lainnya');
        }

        $admin->delete();

        return redirect()->route('admin.admin.index')
            ->with('success', 'Admin berhasil dihapus');
    }
}