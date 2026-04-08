<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class kategoriContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataKategori = Kategori::all();
        return view('Admin.kategori', compact('dataKategori'));
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $dataKategori = Kategori::when($search, function ($query, $search){
            return $query->where('ket_kategori', 'like', "%$search%");
        })->get();

        return view('Admin.kategori', compact('dataKategori', 'search'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.kategori', compact('dataKategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ket_kategori' => 'required | string',
        ]);

        Kategori::create([
            'ket_kategori' => $request->ket_kategori
        ]);
        
        return redirect()->route('kategori.index')->with('ekSuccess', 'Data kategori berhasil ditambah.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('katDeleted', 'Data siswa berhasil dihapus.');

    }
}
