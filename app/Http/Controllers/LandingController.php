<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan; // Kita ambil data layanan biar harga di depan dinamis

class LandingController extends Controller
{
    public function index()
    {
        // Ambil data layanan buat ditampilkan di section "Harga"
        $layanans = Layanan::all();
        return view('landing', compact('layanans'));
    }
}