@extends('layouts.app')

@section('title', 'Kelola Peminjaman')
@section('subtitle', 'Persetujuan, penolakan, dan pengembalian inventaris sekolah')

@section('content')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h3 class="font-bold text-slate-800 text-base">Daftar Peminjaman Siswa</h3>
            <p class="text-xs text-slate-400">Kelola persetujuan dan pengembalian barang inventaris</p>
        </div>
        
        <!-- Filter Status -->
        <form method="GET" action="{{ route('borrowing.index') }}" class="flex items-center space-x-2">
            <select name="status" onchange="this.form.submit()" class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none">
                <option value="">Semua Status</option>
                <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                <option value="Approved" {{ request('status') === 'Approved' ? 'selected' : '' }}>Approved (Dipinjam)</option>
                <option value="Dikembalikan" {{ request('status') === 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                <option value="Rejected" {{ request('status') === 'Rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
            </select>
        </form>
    </div>

    <!-- Tabel Kelola Peminjaman -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-[11px] font-bold uppercase text-slate-400 border-b border-slate-100">
                    <th class="py-3.5 px-4">PEMINJAM</th>
                    <th class="py-3.5 px-4">BARANG</th>
                    <th class="py-3.5 px-4">JUMLAH</th>
                    <th class="py-3.5 px-4">TGL PINJAM</th>
                    <th class="py-3.5 px-4">RENCANA KEMBALI</th>
                    <th class="py-3.5 px-4">STATUS</th>
                    <th class="py-3.5 px-4 text-center">AKSI PETUGAS</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-600">
                @forelse($borrowings as $item)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="py-4 px-4 font-bold text-slate-800">{{ $item->user->name ?? '-' }}</td>
                    <td class="py-4 px-4 font-semibold text-slate-700">{{ $item->inventory->nama_alat ?? '-' }}</td>
                    <td class="py-4 px-4 font-extrabold text-slate-800">{{ $item->jumlah }} Unit</td>
                    <td class="py-4 px-4 text-slate-400">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}</td>
                    <td class="py-4 px-4 text-slate-400">{{ \Carbon\Carbon::parse($item->rencana_tgl_kembali)->format('d M Y') }}</td>
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
                            <div class="flex justify-center space-x-2">
                                <form action="{{ route('borrowing.approve', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Setujui peminjaman ini?')" class="px-3 py-1 bg-teal-600 text-white rounded-lg font-bold text-[11px] hover:bg-teal-700 transition">
                                        Setujui
                                    </button>
                                </form>
                                <form action="{{ route('borrowing.reject', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Tolak peminjaman ini?')" class="px-3 py-1 bg-rose-500 text-white rounded-lg font-bold text-[11px] hover:bg-rose-600 transition">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        @elseif($item->status === 'Approved')
                            <form action="{{ route('borrowing.return', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Tandai barang ini telah dikembalikan?')" class="px-3 py-1 bg-slate-800 text-white rounded-lg font-bold text-[11px] hover:bg-slate-900 transition">
                                    Tandai Dikembalikan
                                </button>
                            </form>
                        @else
                            <span class="text-slate-400 italic text-[11px]">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-8 text-center text-slate-400">Belum ada data peminjaman yang masuk.</td>
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