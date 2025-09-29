<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
{
    // Menampilkan daftar user
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Form tambah user
    public function create()
    {
        return view('admin.create'); // bukan admin.users.create
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|string|in:user,admin',
            'gambar'   => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('users', 'public');
        }

        User::create($data);

        return redirect()->route('admin.users')->with('success', 'User berhasil dibuat!');
    }

    // Form edit user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit', compact('user')); // bukan admin.users.edit
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|string|in:user,admin',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:6|confirmed',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('gambar')) {
            // hapus gambar lama kalau ada
            if ($user->gambar && Storage::disk('public')->exists($user->gambar)) {
                Storage::disk('public')->delete($user->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('users', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui!');
    }

    // Hapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->gambar && Storage::disk('public')->exists($user->gambar)) {
            Storage::disk('public')->delete($user->gambar);
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
    }

    public function updatePermission(Request $request, $id)
{
    $user = User::findOrFail($id);

    $permissions = $request->input('permissions', []);

    // Simpan sebagai string (contoh: "konten,kategori")
    $user->role = implode(',', $permissions) ?: 'user';
    $user->save();

    return redirect()->route('admin.users')->with('success', 'Permission berhasil diperbarui!');
}


public function export()
{
    $users = User::all();

    $response = new StreamedResponse(function() use ($users) {
        $handle = fopen('php://output', 'w');
        // Header CSV
        fputcsv($handle, ['ID', 'Nama', 'Email', 'Role']);

        foreach ($users as $user) {
            fputcsv($handle, [$user->id, $user->name, $user->email, $user->role]);
        }

        fclose($handle);
    });

    $response->headers->set('Content-Type', 'text/csv');
    $response->headers->set('Content-Disposition', 'attachment; filename="users.csv"');

    return $response;
}

}
