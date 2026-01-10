<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    public function index()
    {

        $pesanans = Pesanan::where('idUser', Auth::user()->idUser)
                            ->with('transaksi')
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('pelanggan.dashboard', compact('pesanans'));
    }

    public function create()
    {
        $layanans = Layanan::all();
        return view('pelanggan.create_pesanan', compact('layanans'));
    }

    // Proses Simpan Pesanan
    public function store(Request $request)
    {
        $request->validate([
            'layanan' => 'required|array',
            'layanan.*' => 'exists:layanans,idLayanan',
            'jumlah' => 'required|array',
            'jumlah.*' => 'numeric|min:0',
        ]);

        if (array_sum($request->jumlah) <= 0) {
            return back()->with('error', 'Anda belum mengisi jumlah item laundry satupun!');
        }

        try {
            DB::beginTransaction();

            // 1. Buat Header Pesanan
            $pesanan = Pesanan::create([
                'idUser' => Auth::user()->idUser,
                'tanggalPesan' => now(),
                'statusPesanan' => 'Menunggu Validasi',
                'totalHarga' => 0
            ]);

            $totalHarga = 0;
            $itemCount = 0;

            // 2. Simpan Detail Pesanan
            foreach ($request->layanan as $key => $idLayanan) {
                $qty = $request->jumlah[$key] ?? 0;

                if ($qty > 0) {
                    $layanan = Layanan::find($idLayanan);
                    $subtotal = $layanan->harga * $qty;

                    DetailPesanan::create([
                        'idPesanan' => $pesanan->idPesanan,
                        'idLayanan' => $idLayanan,
                        'jumlah' => $qty,
                        'subtotal' => $subtotal
                    ]);

                    $totalHarga += $subtotal;
                    $itemCount++;
                }
            }

            if ($itemCount == 0) {
                DB::rollback();
                return back()->with('error', 'Gagal memproses pesanan: Tidak ada item yang valid.');
            }

            // 3. Update Total Harga
            $pesanan->update(['totalHarga' => $totalHarga]);

            DB::commit();
            return redirect()->route('pelanggan.dashboard')->with('success', 'Pesanan berhasil dibuat! Menunggu validasi admin.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}