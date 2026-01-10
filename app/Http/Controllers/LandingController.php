<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Pesanan;

class LandingController extends Controller
{
    public function index()
    {
        $layanans = Layanan::all();
        return view('landing', compact('layanans'));
    }

    public function cekPesanan(Request $request)
    {
        $search = $request->query('id');
        $pesanan = null;

        if($search) {
            $pesanan = Pesanan::with(['user', 'details.layanan'])
                            ->where('idPesanan', $search)
                            ->first();
        }

        return view('cek-laundry', compact('pesanan', 'search'));
    }
}