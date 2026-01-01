<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    private function checkAdmin() {
        if (Auth::user()->role !== 'admin') abort(403, 'Akses Ditolak.');
    }

    public function index()
    {
        $this->checkAdmin();

        $stats = [
            'masuk' => Pesanan::where('statusPesanan', 'Menunggu Validasi')->count(),
            'proses' => Pesanan::whereIn('statusPesanan', ['Antre', 'Cuci', 'Setrika'])->count(),
            'siap_ambil' => Pesanan::where('statusPesanan', 'Selesai')->doesntHave('transaksi')->count(),
        ];

        $pesanans = Pesanan::with(['user', 'details.layanan', 'transaksi'])
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('admin.dashboard', compact('stats', 'pesanans'));
    }

    public function show($id)
    {
        $this->checkAdmin();
        $pesanan = Pesanan::with(['user', 'details.layanan', 'transaksi'])->findOrFail($id);
        return view('admin.detail', compact('pesanan'));
    }

    // --- UPDATE STATUS LOGIC (DIPERBARUI) ---
    public function updateStatus(Request $request, $id)
    {
        $this->checkAdmin();
        $pesanan = Pesanan::findOrFail($id);

        $request->validate([
            'status' => 'required',
            // Jika status yang dikirim adalah Antre (Validasi), tanggal estimasi wajib diisi
            'estimasi' => 'nullable|date|after_or_equal:today'
        ]);

        // Jika status berubah jadi Antre, simpan estimasinya
        if ($request->status == 'Antre' && $request->has('estimasi')) {
            $pesanan->estimasiSelesai = $request->estimasi;
        }

        $pesanan->statusPesanan = $request->status;
        $pesanan->save();

        return back()->with('success', "Status pesanan #{$id} diperbarui menjadi {$request->status}");
    }

    public function formBayar($id)
    {
        $this->checkAdmin();
        $pesanan = Pesanan::with(['details', 'transaksi'])->findOrFail($id);

        if($pesanan->transaksi) {
            return redirect()->route('admin.pesanan.struk', $id);
        }

        return view('admin.bayar', compact('pesanan'));
    }

    public function processBayar(Request $request, $id)
    {
        $this->checkAdmin();
        $request->validate([
            'total_bayar' => 'required|numeric',
            'uang_bayar' => 'required|numeric|min:'.$request->total_bayar,
            'metode' => 'required'
        ]);

        Transaksi::create([
            'idPesanan' => $id,
            'tanggalTransaksi' => now(),
            'totalBayar' => $request->total_bayar,
            'metodePembayaran' => $request->metode
        ]);

        return redirect()->route('admin.pesanan.struk', $id)->with('success', 'Pembayaran Berhasil!');
    }

    public function cetakStruk($id)
    {
        $this->checkAdmin();
        $pesanan = Pesanan::with(['user', 'details.layanan', 'transaksi'])->findOrFail($id);

        if(!$pesanan->transaksi) {
            return back()->with('error', 'Pesanan belum dibayar!');
        }

        return view('admin.struk', compact('pesanan'));
    }

    public function laporan()
    {
        $this->checkAdmin();

        $today = Carbon::today();
        $pendapatanHariIni = Transaksi::whereDate('created_at', $today)->sum('totalBayar');
        $pendapatanBulanIni = Transaksi::whereMonth('created_at', date('m'))->sum('totalBayar');
        $totalTransaksi = Transaksi::count();
        $transaksiTerbaru = Transaksi::with('pesanan.user')->latest()->limit(5)->get();

        return view('admin.laporan', compact(
            'pendapatanHariIni',
            'pendapatanBulanIni',
            'totalTransaksi',
            'transaksiTerbaru'
        ));
    }

    // FITUR CETAK LABEL / TAGGING
    public function cetakLabel($id)
    {
        $this->checkAdmin();

        // Ambil data pesanan beserta detailnya
        $pesanan = Pesanan::with(['user', 'details.layanan'])->findOrFail($id);

        // Kita hitung total pcs/kg untuk info di label
        $totalItem = $pesanan->details->sum('jumlah');

        return view('admin.label', compact('pesanan', 'totalItem'));
    }


}