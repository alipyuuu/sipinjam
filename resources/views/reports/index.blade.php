@extends('layouts.app')

@section('title', 'Laporan Peminjaman')
@section('subtitle', 'Cetak dan arsip laporan transaksi peminjaman inventaris sekolah')

@section('content')
<style>
    @media print {
        aside, header, .no-print { display: none !important; }
        .ml-64 { margin-left: 0 !important; }
        main { padding: 0 !important; }
        body { background: white !important; }
    }
</style>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
    <!-- Filter Tanggal & Tombol Cetak -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 no-print">
        <form method="GET" action="{{ route('borrowing.report') }}" class="flex items-center space-x-3">
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">DARI TANGGAL</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">SAMPAI TANGGAL</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700">
            </div>
            <div class="pt-4">
                <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold hover:bg-slate-900 transition">Filter</button>
            </div>
        </form>

        <button onclick="window.print()" class="px-5 py-2.5 bg-teal-600 text-white rounded-xl text-xs font-bold uppercase hover:bg-teal-700 transition flex items-center space-x-2 shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            <span>Cetak Laporan</span>
        </button>
    </div>

    <!-- Kop Laporan Saat Cetak -->
    <div class="text-center mb-6 border-b pb-4">
        <h2 class="text-lg font-bold text-slate-900 uppercase">LAPORAN PEMINJAMAN INVENTARIS SEKOLAH</h2>
        <p class="text-xs text-slate-500">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
    </div>

    <!-- Tabel Data Laporan -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse border border-slate-200">
            <thead>
                <tr class="text-[11px] font-bold uppercase text-slate-700 bg-slate-100">
                    <th class="py-2.5 px-3 border border-slate-200 text-center">NO</th>
                    <th class="py-2.5 px-3 border border-slate-200">PEMINJAM</th>
                    <th class="py-2.5 px-3 border border-slate-200">NAMA BARANG</th>
                    <th class="py-2.5 px-3 border border-slate-200 text-center">JUMLAH</th>
                    <th class="py-2.5 px-3 border border-slate-200">TGL PINJAM</th>
                    <th class="py-2.5 px-3 border border-slate-200">RENCANA KEMBALI</th>
                    <th class="py-2.5 px-3 border border-slate-200">STATUS</th>
                </tr>
            </thead>
            <tbody class="text-xs text-slate-700">
                @forelse($borrowings as $index => $item)
                <tr>
                    <td class="py-2.5 px-3 border border-slate-200 text-center">{{ $index + 1 }}</td>
                    <td class="py-2.5 px-3 border border-slate-200 font-semibold">{{ $item->user->name ?? '-' }}</td>
                    <td class="py-2.5 px-3 border border-slate-200">{{ $item->inventory->nama_alat ?? '-' }}</td>
                    <td class="py-2.5 px-3 border border-slate-200 font-bold text-center">{{ $item->jumlah }}</td>
                    <td class="py-2.5 px-3 border border-slate-200">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') }}</td>
                    <td class="py-2.5 px-3 border border-slate-200">{{ \Carbon\Carbon::parse($item->rencana_tgl_kembali)->format('d/m/Y') }}</td>
                    <td class="py-2.5 px-3 border border-slate-200 font-semibold">{{ $item->status }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-6 text-center text-slate-400">Tidak ada transaksi pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection