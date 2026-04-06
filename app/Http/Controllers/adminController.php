<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class adminController extends Controller
{
    /* Display a listing of the resource. */
    public function index()
    {
        $dataAdmin = Admin::all();
        return view('Admin.akunAdmin', compact('dataAdmin'));
    }

    /* Show the form for creating a new resource. */
    public function create()
    {
        $dataAdmin = Admin::all();
        return view('Admin.akunAdmin', compact('dataAdmin'));
    }

    /* Store a newly created resource in storage. */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:6',
        ],[
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        // Cek password
        $passwords = Admin::pluck('password')->first(function ($hashedPassword) use ($request) {
            return Hash::check($request->password, $hashedPassword);
        });

        if ($passwords) {
            return redirect()->route('admin.create')->with('errorPASS', 'Password sudah digunakan, silakan gunakan password lain bos!');
        }

        Admin::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.index')->with('adminSuccess', 'Admin berhasil ditambahkan.');
    }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = Admin::findOrFail($id);
        return view('Admin.editAdmin', compact('admin'));
    }

    /* Update the specified resource in storage. */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:6',
        ],[
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        // Cek password di edit admin
        $passwords = Admin::pluck('password')->first(function ($hashedPassword) use ($request) {
            return Hash::check($request->password, $hashedPassword);
        });

        if ($passwords) {
            return redirect()->route('admin.edit', $id)->with('errorPASS', 'Password sudah digunakan, silakan gunakan password lain bos!');
        }

        $admin = Admin::findOrFail($id);
        $admin->update([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.index')->with('updateSuccess', 'Admin berhasil diperbarui bos!');
    }

    /*Remove the specified resource from storage. */
    public function destroy(string $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.index')->with('adminDeleted', 'Admin berhasil dihapus.');
    }
}
