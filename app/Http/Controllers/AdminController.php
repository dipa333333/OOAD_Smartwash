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
        $pesanans = Pesanan::with(['user', 'details.layanan', 'transaksi'])->orderBy('created_at', 'desc')->paginate(5);
        return view('admin.dashboard', compact('stats', 'pesanans'));
    }

    public function show($id)
    {
        $this->checkAdmin();
        $pesanan = Pesanan::with(['user', 'details.layanan', 'transaksi'])->findOrFail($id);
        return view('admin.detail', compact('pesanan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $this->checkAdmin();
        $pesanan = Pesanan::findOrFail($id);
        $request->validate(['status' => 'required', 'estimasi' => 'nullable|date|after_or_equal:today']);

        if ($request->status == 'Antre' && $request->has('estimasi')) {
            $pesanan->estimasiSelesai = $request->estimasi;
        }

        $pesanan->statusPesanan = $request->status;
        $pesanan->save();
        return back()->with('success', "Status pesanan #{$id} diperbarui!");
    }

    // --- FUNGSI BAYAR  ---
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

        return redirect()->route('admin.pesanan.struk', $id)
        ->with('success', 'Pembayaran Berhasil!')
        ->with('uang_bayar', $request->uang_bayar);
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

    public function cetakLabel($id)
    {
        $this->checkAdmin();
        $pesanan = Pesanan::with(['user', 'details.layanan'])->findOrFail($id);
        $totalItem = $pesanan->details->sum('jumlah');
        return view('admin.label', compact('pesanan', 'totalItem'));
    }

    // --- FUNGSI LAPORAN ---
    public function laporan(Request $request)
    {
        $this->checkAdmin();

        $bulanTerpilih = (int) $request->get('bulan', date('m'));
        $tahunTerpilih = (int) $request->get('tahun', date('Y'));

        // 1. DATA KARTU STATISTIK
        $pendapatanHariIni = Transaksi::whereDate('created_at', Carbon::today())->sum('totalBayar');

        $pendapatanFilter = Transaksi::whereMonth('created_at', $bulanTerpilih)
                                     ->whereYear('created_at', $tahunTerpilih)
                                     ->sum('totalBayar');

        $totalTransaksiGlobal = Transaksi::count();

        // 2. DATA UNTUK TABEL RIWAYAT
        $transaksiTerbaru = Transaksi::with('pesanan.user')
                                    ->whereMonth('created_at', $bulanTerpilih)
                                    ->whereYear('created_at', $tahunTerpilih)
                                    ->latest()
                                    ->get();

        // 3. DATA BARU UNTUK CHART/GRAFIK (Group per Tanggal)
        $chartData = Transaksi::selectRaw('DATE(created_at) as tanggal, SUM(totalBayar) as total')
                            ->whereMonth('created_at', $bulanTerpilih)
                            ->whereYear('created_at', $tahunTerpilih)
                            ->groupBy('tanggal')
                            ->orderBy('tanggal', 'asc')
                            ->get();

        $chartLabels = $chartData->map(function($item) {
            return Carbon::parse($item->tanggal)->format('d');
        });

        $chartTotal = $chartData->pluck('total');

        // 4. LOGIC DROPDOWN TAHUN
        $tahunDiDatabase = Transaksi::selectRaw('YEAR(created_at) as tahun')->distinct()->pluck('tahun')->toArray();
        $tahunDiDatabase[] = (int) date('Y');
        $listTahun = array_unique($tahunDiDatabase);
        rsort($listTahun);

        return view('admin.laporan', compact(
            'pendapatanHariIni', 'pendapatanFilter', 'totalTransaksiGlobal',
            'transaksiTerbaru', 'bulanTerpilih', 'tahunTerpilih', 'listTahun',
            'chartLabels', 'chartTotal' 
        ));
    }
}