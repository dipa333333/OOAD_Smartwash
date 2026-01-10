<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use Illuminate\Support\Facades\Auth;

class LayananController extends Controller
{
    private function checkAdmin() {
        if (Auth::user()->role !== 'admin') abort(403, 'Akses Ditolak.');
    }

    // 1. Tampilkan Daftar Layanan
    public function index()
    {
        $this->checkAdmin();
        $layanans = Layanan::all();
        return view('admin.layanan.index', compact('layanans'));
    }

    // 2. Tampilkan Form Tambah
    public function create()
    {
        $this->checkAdmin();
        return view('admin.layanan.create');
    }

    // 3. Proses Simpan Data Baru
    public function store(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'namaLayanan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0'
        ]);

        Layanan::create($request->all());

        return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil ditambahkan!');
    }

    // 4. Tampilkan Form Edit
    public function edit($id)
    {
        $this->checkAdmin();
        $layanan = Layanan::findOrFail($id);
        return view('admin.layanan.edit', compact('layanan'));
    }

    // 5. Proses Update Data
    public function update(Request $request, $id)
    {
        $this->checkAdmin();
        $request->validate([
            'namaLayanan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0'
        ]);

        $layanan = Layanan::findOrFail($id);
        $layanan->update($request->all());

        return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil diperbarui!');
    }

    // 6. Proses Hapus Data
    public function destroy($id)
    {
        $this->checkAdmin();
        $layanan = Layanan::findOrFail($id);

        $layanan->delete();

        return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil dihapus!');
    }
}