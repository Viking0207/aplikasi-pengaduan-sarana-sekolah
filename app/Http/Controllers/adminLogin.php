<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class adminLogin extends Controller
{
    /* Display a listing of the resource. */
    public function index()
    {
        $dataAdmin = Admin::all();
        return view('Admin.loginAdmin', compact('dataAdmin'));
    }

    /* Display the specified resource. */

    public function showForm()
    {
        // Logika untuk menampilkan form login siswa
        return view('Admin.loginAdmin');
    }

    /* fungsi login */ 

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|max:8',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if (!$admin) {
            return redirect()->route('loginAdmin')->with('errorUSER', 'Username atau password salah bos!');
        }

        session(['admin_username' => $admin->username]);

        return redirect()->route('admin.homeAdmin')->with('success', 'Selamat datang bos!.');
    }

    public function logout()
    {
        // Logika untuk logout admin
        return redirect()->route('loginAdmin')->with('success', 'Logout berhasil.');
    }

}
