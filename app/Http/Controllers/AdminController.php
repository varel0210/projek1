<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    
    // Tampilkan dashboard admin
    public function dashboard()
    {
        $users = User::all(); // ambil semua user
        return view('admin.dashboard', compact('users'));
    }

    // Tampilkan halaman daftar user
    public function users()
    {
        $users = User::all(); 
        return view('admin.users', compact('users'));
    }
}
