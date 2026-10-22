@extends('layouts.app')

@section('title', 'Riwayat Peminjaman Saya')
@section('subtitle', 'Daftar riwayat dan status permohonan peminjaman barang kamu')

@section('content')
<!-- Spanduk Notifikasi Berhasil -->
@if(session('success'))
<div class="mb-6 p-5 bg-emerald-500 text-white rounded-2xl shadow-lg shadow-emerald-500/20 flex items-center justify-between animate-bounce">
    <div class="flex items-center space-x-3">
        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-xl font-bold">
            ✓
        </div>
        <div>
            <h4 class="font-extrabold text-sm">Pengajuan Berhasil Dikirim!</h4>
            <p class="text-xs text-emerald-100">{{ session('success') }}</p>
        </div>
    </div>
    <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white font-bold text-sm">✕</button>
</div>
@endif

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h3 class="font-bold text-slate-800 text-base">Rekap Permohonan Saya</h3>
            <p class="text-xs text-slate-400">Seluruh riwayat peminjaman kamu otomatis tercatat di sini</p>
        </div>
        <form method="GET" action="{{ route('borrowing.history') }}">
            <select name="status" onchange="this.form.submit()" class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none">
                <option value="">Semua Status</option>
                <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Approved" {{ request('status') === 'Approved' ? 'selected' : '' }}>Dipinjam</option>
                <option value="Dikembalikan" {{ request('status') === 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                <option value="Rejected" {{ request('status') === 'Rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </form>
    </div>

    <!-- Tabel Rekap Peminjaman -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-[11px] font-bold uppercase text-slate-400 border-b border-slate-100">
                    <th class="py-3.5 px-4">NAMA BARANG</th>
                    <th class="py-3.5 px-4">JUMLAH</th>
                    <th class="py-3.5 px-4">TGL PINJAM</th>
                    <th class="py-3.5 px-4">RENCANA KEMBALI</th>
                    <th class="py-3.5 px-4">STATUS</th>
                    <th class="py-3.5 px-4 text-center">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-600">
                @forelse($borrowings as $item)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="py-4 px-4 font-bold text-slate-800">{{ $item->inventory->nama_alat ?? '-' }}</td>
                    <td class="py-4 px-4 font-extrabold text-slate-800">{{ $item->jumlah }} Unit</td>
                    <td class="py-4 px-4 text-slate-400 font-semibold">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}</td>
                    <td class="py-4 px-4 text-slate-400 font-semibold">{{ \Carbon\Carbon::parse($item->rencana_tgl_kembali)->format('d M Y') }}</td>
                    <td class="py-4 px-4">
                        @if($item->status === 'Pending')
                            <span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 font-bold text-[10px]">Menunggu Persetujuan</span>
                        @elseif($item->status === 'Approved')
                            <span class="px-2.5 py-1 rounded-full bg-sky-50 text-sky-600 font-bold text-[10px]">Sedang Dipinjam</span>
                        @elseif($item->status === 'Dikembalikan')
                            <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 font-bold text-[10px]">Dikembalikan</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full bg-rose-50 text-rose-600 font-bold text-[10px]">Ditolak</span>
                        @endif
                    </td>
                    <td class="py-4 px-4 text-center">
                        @if($item->status === 'Pending')
                            <form action="{{ route('borrowing.cancel', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Batalkan pengajuan ini?')" class="px-3 py-1 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg font-bold text-[11px] transition">
                                    Batalkan
                                </button>
                            </form>
                        @else
                            <span class="text-slate-400 italic text-[11px]">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-slate-400">Belum ada riwayat peminjaman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $borrowings->links() }}
    </div>
</div>
@endsection