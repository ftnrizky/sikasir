<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UserController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    // Hanya admin bisa akses
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    // List user
    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.users.index', compact('users'));
    }

    // Form tambah user
    public function create()
    {
        $roles = ['admin','kasir','bar','kitchen'];
        return view('admin.users.create', compact('roles'));
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|string|min:6',
            'role' => 'required|in:admin,kasir,bar,kitchen'
        ]);

        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password)
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')->with('success','User berhasil ditambahkan.');
    }

    // Form edit user
    public function edit(User $user)
    {
        $roles = ['admin','kasir','bar','kitchen'];
        return view('admin.users.edit', compact('user','roles'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|email|unique:users,email,'.$user->id,
            'password'=> 'nullable|string|min:6',
            'role' => 'required|in:admin,kasir,bar,kitchen'
        ]);

        $user->update([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> $request->password ? bcrypt($request->password) : $user->password
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')->with('success','User berhasil diperbarui.');
    }

    // Hapus user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','User berhasil dihapus.');
    }
}
