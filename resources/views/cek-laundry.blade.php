<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Laundry - SmartWash</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col items-center justify-center p-6 relative overflow-hidden">

    <div class="absolute top-0 left-0 w-full h-64 bg-blue-600 rounded-b-[3rem] -z-10"></div>
    <div class="absolute top-10 right-10 text-white opacity-10 text-9xl font-black -z-10">🔍</div>

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-white mb-2">Lacak Laundry 🧺</h1>
            <p class="text-blue-200 text-sm font-medium">Masukkan Nomor Nota untuk cek status.</p>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-blue-900/10 p-2 mb-6">
            <form action="{{ route('cek.pesanan') }}" method="GET" class="flex gap-2">
                <input type="number" name="id" value="{{ $search }}" placeholder="Contoh: 15" required
                    class="w-full bg-gray-50 border-none rounded-xl px-6 py-4 font-bold text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 transition placeholder:text-gray-300">
                <button type="submit" class="bg-blue-600 text-white rounded-xl px-6 font-black hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                    CARI
                </button>
            </form>
        </div>

        @if($search)
            @if($pesanan)
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200 p-8 border border-gray-100">

                    <div class="flex justify-between items-center mb-8 border-b border-gray-50 pb-6">
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Pelanggan</p>
                            <h3 class="text-xl font-black text-gray-800">{{ $pesanan->user->nama }}</h3>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Total</p>
                            <h3 class="text-xl font-black text-blue-600">Rp {{ number_format($pesanan->totalHarga, 0, ',', '.') }}</h3>
                        </div>
                    </div>

                    <div class="relative pl-4 border-l-2 border-gray-100 space-y-8">
                        @php
                            $steps = ['Menunggu Validasi', 'Antre', 'Cuci', 'Setrika', 'Selesai'];
                            $currentStep = array_search($pesanan->statusPesanan, $steps);
                        @endphp

                        @foreach($steps as $index => $step)
                            <div class="relative">
                                <div class="absolute -left-[21px] top-1 w-4 h-4 rounded-full border-2 border-white
                                    {{ $index <= $currentStep ? 'bg-blue-600 shadow-lg shadow-blue-300 scale-125' : 'bg-gray-200' }}">
                                </div>

                                <div>
                                    <h4 class="font-bold {{ $index <= $currentStep ? 'text-gray-800' : 'text-gray-300' }}">
                                        {{ $step }}
                                        @if($index == $currentStep)
                                            <span class="ml-2 bg-blue-100 text-blue-600 text-[10px] px-2 py-0.5 rounded-full uppercase tracking-widest">Sekarang</span>
                                        @endif
                                    </h4>

                                    @if($step == 'Antre' && $index <= $currentStep && $pesanan->estimasiSelesai)
                                        <p class="text-xs text-gray-400 mt-1">Estimasi Selesai: {{ \Carbon\Carbon::parse($pesanan->estimasiSelesai)->format('d M Y') }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a href="https://wa.me/6281234567890" class="block mt-8 text-center bg-gray-50 text-gray-500 py-3 rounded-xl text-xs font-bold hover:bg-gray-100 transition">
                        Butuh bantuan? Hubungi Admin
                    </a>

                    <a href="{{ route('home') }}" class="block mt-2 text-center text-blue-600 py-2 text-xs font-bold hover:underline">
                        Kembali ke Beranda
                    </a>
                </div>
            @else
                <div class="bg-white rounded-[2.5rem] shadow-sm p-8 text-center border border-red-100">
                    <div class="text-5xl mb-4">🤷‍♂️</div>
                    <h3 class="font-black text-gray-800 mb-2">Pesanan Tidak Ditemukan</h3>
                    <p class="text-sm text-gray-400">Coba cek kembali nomor nota Anda. Pastikan angka yang dimasukkan benar.</p>
                </div>
            @endif
        @endif

    </div>
</body>
</html>