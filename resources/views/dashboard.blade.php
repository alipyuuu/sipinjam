@extends('layouts.app')

@section('title', Auth::user()->role === 'petugas' ? 'Dashboard Petugas' : 'Dashboard Siswa')
@section('subtitle', Auth::user()->role === 'petugas' ? 'Ringkasan dan pemantauan inventaris sekolah' : 'Ajukan dan pantau status peminjaman barang kamu')

@section('content')
@if(Auth::user()->role === 'petugas')
    <!-- ==================== DASHBOARD PETUGAS ==================== -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase text-slate-400">Total Inventaris</span>
                <div class="p-2.5 bg-slate-900 text-white rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-slate-800">{{ $totalInventaris }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Barang terdaftar dalam sistem</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase text-slate-400">Sedang Dipinjam</span>
                <div class="p-2.5 bg-teal-500 text-white rounded-xl shadow-md shadow-teal-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-slate-800">{{ $sedangDipinjam }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Belum dikembalikan ke gudang</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase text-slate-400">Bulan Ini</span>
                <div class="p-2.5 bg-indigo-600 text-white rounded-xl shadow-md shadow-indigo-600/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-slate-800">{{ $peminjamanBulanIni }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Transaksi pada {{ date('M Y') }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase text-slate-400">Terlambat</span>
                <div class="p-2.5 bg-rose-500 text-white rounded-xl shadow-md shadow-rose-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-slate-800">{{ $terlambatKembali }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Perlu pemantauan petugas</p>
        </div>
    </div>

    <!-- Grafik & Status -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <h3 class="font-bold text-slate-800 text-sm mb-1">Aktivitas Peminjaman Per Bulan</h3>
            <p class="text-xs text-slate-400 mb-6">Statistik peminjaman inventaris tahun {{ date('Y') }}</p>
            <div class="h-52">
                <canvas id="borrowChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="font-bold text-slate-800 text-sm mb-6">Status Kondisi Inventaris</h3>
                <div class="space-y-5">
                    <div>
                        <div class="flex justify-between text-xs font-semibold text-slate-600 mb-1.5">
                            <span>Baik / Tersedia</span>
                            <span class="font-bold text-slate-800">{{ $statusTersedia }} Unit</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-emerald-500 h-full rounded-full" style="width: 80%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold text-slate-600 mb-1.5">
                            <span>Sedang Dipinjam</span>
                            <span class="font-bold text-slate-800">{{ $statusDipinjam }} Unit</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-teal-600 h-full rounded-full" style="width: 25%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold text-slate-600 mb-1.5">
                            <span>Rusak / Perlu Perbaikan</span>
                            <span class="font-bold text-slate-800">{{ $statusRusak }} Unit</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-rose-500 h-full rounded-full" style="width: 10%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tombol Aktif Ke Data Inventaris -->
            <a href="{{ route('inventaris.index') }}" class="mt-6 block text-center py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-700 rounded-xl text-xs font-bold transition">
                Lihat Data Inventaris →
            </a>
        </div>
    </div>

@else
    <!-- ==================== DASHBOARD SISWA ==================== -->
    <div class="bg-gradient-to-r from-[#111827] via-slate-900 to-slate-800 rounded-3xl p-8 text-white mb-8 shadow-xl relative overflow-hidden">
        <div class="relative z-10 max-w-2xl">
            <span class="inline-block px-3 py-1 bg-teal-500/20 text-teal-300 border border-teal-500/30 rounded-full text-[11px] font-extrabold uppercase mb-3">Selamat Datang</span>
            <h3 class="text-2xl font-extrabold tracking-tight mb-2">Halo, {{ Auth::user()->name }}! 👋</h3>
            <p class="text-xs text-slate-300 leading-relaxed mb-6">Butuh alat atau perlengkapan sekolah? Silakan isi formulir peminjaman dengan cepat di sini.</p>
            <a href="{{ route('borrowing.create') }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-lg shadow-teal-500/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Ajukan Peminjaman Barang</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-teal-50 text-teal-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"></path></svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-slate-800">{{ $sedangDipinjam }}</p>
                <p class="text-xs font-semibold text-slate-500">Barang Sedang Dipinjam</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-slate-800">{{ $peminjamanBulanIni }}</p>
                <p class="text-xs font-semibold text-slate-500">Pengajuan Bulan Ini</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-slate-800">{{ $terlambatKembali }}</p>
                <p class="text-xs font-semibold text-slate-500">Terlambat Dikembalikan</p>
            </div>
        </div>
    </div>
@endif

<!-- Tabel Aktivitas Peminjaman Terbaru -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-slate-800 text-sm">
            {{ Auth::user()->role === 'petugas' ? 'Aktivitas Peminjaman Terkini' : 'Riwayat Peminjaman Saya' }}
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-[11px] font-bold uppercase text-slate-400 border-b border-slate-100">
                    <th class="py-3.5 px-4">TANGGAL</th>
                    <th class="py-3.5 px-4">BARANG</th>
                    <th class="py-3.5 px-4">PEMINJAM</th>
                    <th class="py-3.5 px-4">STATUS</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-600">
                @forelse($aktivitasTerbaru as $item)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="py-3.5 px-4 text-slate-400 font-semibold">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}</td>
                    <td class="py-3.5 px-4 font-bold text-slate-800">{{ $item->inventory->nama_alat ?? '-' }}</td>
                    <td class="py-3.5 px-4">{{ $item->user->name ?? '-' }}</td>
                    <td class="py-3.5 px-4">
                        @if($item->status === 'Approved')
                            <span class="px-2.5 py-1 rounded-full bg-teal-50 text-teal-600 font-bold text-[10px]">Dipinjam</span>
                        @elseif($item->status === 'Pending')
                            <span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 font-bold text-[10px]">Menunggu Persetujuan</span>
                        @elseif($item->status === 'Dikembalikan')
                            <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 font-bold text-[10px]">Dikembalikan</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full bg-rose-50 text-rose-600 font-bold text-[10px]">Ditolak</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-8 text-center text-slate-400">Belum ada riwayat aktivitas terbaru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
@if(Auth::user()->role === 'petugas')
<script>
    const ctx = document.getElementById('borrowChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'],
            datasets: [{
                data: [18, 25, 14, 32, 28, 21],
                backgroundColor: '#0d9488',
                borderRadius: 8,
                barThickness: 20
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { borderDash: [4, 4] }, ticks: { color: '#94a3b8', font: { size: 10 } } },
                x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 10 } } }
            }
        }
    });
</script>
@endif
@endsection