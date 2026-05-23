<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = User::orderBy('created_at', 'desc')->paginate(10);
        $isSuperAdmin = auth()->user()->role === 'super_admin';
        return view('admin.admin.index', compact('admins', 'isSuperAdmin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only super_admin can create new admins
        $isSuperAdmin = auth()->user()->role === 'super_admin';
        return view('admin.admin.create', compact('isSuperAdmin'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:super_admin,admin',
        ]);

        // Only super_admin can create super_admin
        if ($request->role === 'super_admin' && auth()->user()->role !== 'super_admin') {
            return redirect()->route('admin.admin.index')
                ->with('error', 'Anda tidak memiliki权限 untuk membuat super admin');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.admin.index')
            ->with('success', 'Admin berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $admin)
    {
        return view('admin.admin.show', compact('admin'));
    }

/**
     * Show the form for editing the specified resource.
     */
    public function edit(User $admin)
    {
        $isSuperAdmin = auth()->user()->role === 'super_admin';
        
        // Super admin cannot change their own role to admin
        // They can only change role of other admins
        $isEditingSelf = auth()->id() === $admin->id;
        $canChangeRole = $isSuperAdmin && !$isEditingSelf;
        
        return view('admin.admin.edit', compact('admin', 'isSuperAdmin', 'canChangeRole'));
    }

/**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'role' => 'required|in:super_admin,admin',
        ]);

        // Only super_admin can change role to super_admin
        if ($request->role === 'super_admin' && auth()->user()->role !== 'super_admin') {
            return redirect()->route('admin.admin.index')
                ->with('error', 'Anda tidak memiliki权限 untuk membuat super admin');
        }

        // Prevent super_admin from changing their own role to admin
        $isEditingSelf = auth()->id() === $admin->id;
        $currentRole = auth()->user()->role;
        if ($isEditingSelf && $currentRole === 'super_admin' && $request->role === 'admin') {
            return redirect()->route('admin.admin.index')
                ->with('error', 'Super admin tidak dapat mengubah role nya sendiri menjadi admin');
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Update password if filled
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        // Prevent deleting yourself
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.admin.index')
                ->with('error', 'Tidak dapat menghapus akun yang sedang digunakan');
        }

        // Prevent deleting super_admin (only super_admin can delete)
        if ($admin->role === 'super_admin' && auth()->user()->role !== 'super_admin') {
            return redirect()->route('admin.admin.index')
                ->with('error', 'Anda tidak memiliki权限 untuk menghapus super admin');
        }

        // Prevent super_admin from deleting another super_admin
        if ($admin->role === 'super_admin' && auth()->user()->role === 'super_admin') {
            return redirect()->route('admin.admin.index')
                ->with('error', 'Super admin tidak dapat menghapus super admin lainnya');
        }

        $admin->delete();

        return redirect()->route('admin.admin.index')
            ->with('success', 'Admin berhasil dihapus');
    }
}
