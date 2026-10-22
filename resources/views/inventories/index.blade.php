@extends('layouts.app')

@section('title', 'Data Inventaris')
@section('subtitle', 'Kelola daftar peralatan dan foto barang inventaris sekolah')

@section('content')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h3 class="font-bold text-slate-800 text-base">Daftar Inventaris Barang</h3>
            <p class="text-xs text-slate-400">Seluruh item terdaftar beserta stok dan dokumentasi foto</p>
        </div>
        <div class="flex items-center space-x-3">
            <form method="GET" action="{{ route('inventaris.index') }}" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama barang..." class="pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-slate-800 focus:outline-none w-64">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>
            <button onclick="toggleModal()" class="px-4 py-2 bg-[#111827] text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-800 transition flex items-center space-x-2 shadow-md">
                <span>+ TAMBAH BARANG</span>
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-[11px] font-bold uppercase text-slate-400 border-b border-slate-100">
                    <th class="py-3.5 px-4">FOTO</th>
                    <th class="py-3.5 px-4">NAMA BARANG</th>
                    <th class="py-3.5 px-4">KATEGORI</th>
                    <th class="py-3.5 px-4">STOK TERSAAT INI</th>
                    <th class="py-3.5 px-4">KONDISI</th>
                    <th class="py-3.5 px-4 text-center">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-600">
                @forelse($inventories as $item)
    <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition">
        <!-- 1. FOTO -->
        <td class="p-4">
            <a href="{{ route('inventaris.edit', $item->id) }}" class="relative group block w-10 h-10" title="Klik untuk ubah foto">
                <img src="{{ $item->foto ? asset('storage/' . $item->foto) : asset('images/logo.png') }}" 
                     class="w-10 h-10 object-cover rounded-xl border border-slate-200 group-hover:brightness-75 transition">
                <span class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 text-[9px] font-bold text-white bg-black/50 rounded-xl">Edit</span>
            </a>
        </td>

        <!-- 2. NAMA BARANG -->
        <td class="p-4 font-bold text-slate-800 text-xs">
            {{ $item->nama_alat }}
        </td>

        <!-- 3. KATEGORI -->
        <td class="p-4 text-xs text-slate-500">
            <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg font-medium">
                {{ $item->category->nama_kategori ?? $item->category->name ?? '-' }}
            </span>
        </td>

        <!-- 4. STOK TERSAAT INI -->
        <td class="p-4 text-xs font-bold text-slate-700">
            {{ $item->stok }} <span class="text-[10px] text-slate-400 font-normal">Unit</span>
        </td>

        <!-- 5. KONDISI -->
        <td class="p-4 text-xs">
            <span class="px-2.5 py-1 rounded-lg font-semibold text-[11px] 
                {{ $item->kondisi == 'Baik' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                {{ $item->kondisi }}
            </span>
        </td>

        <!-- 6. AKSI -->
        <td class="p-4">
            <div class="flex items-center space-x-2">
                <a href="{{ route('inventaris.edit', $item->id) }}" class="px-3 py-1 bg-teal-50 text-teal-600 rounded-lg text-xs font-semibold hover:bg-teal-100 transition">
                    Edit
                </a>
                
                <form action="{{ route('inventaris.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1 bg-red-50 text-red-500 rounded-lg text-xs font-semibold hover:bg-red-100 transition">
                        Hapus
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center py-12 text-xs font-bold text-slate-400">
            Belum ada data inventaris barang.
        </td>
    </tr>
@endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $inventories->links() }}
    </div>
</div>

<!-- Modal Tambah Barang -->
<div id="modalTambah" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-slate-800 text-base">Tambah Barang Inventaris</h3>
            <button onclick="toggleModal()" class="text-slate-400 hover:text-slate-600 text-lg">✕</button>
        </div>

        <form action="{{ route('inventaris.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">NAMA BARANG *</label>
                <input type="text" name="nama_alat" placeholder="Masukkan nama alat/barang" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-slate-800 focus:outline-none" required>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">KATEGORI *</label>
                <select name="category_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-slate-800 focus:outline-none" required>
                    <option value="">Pilih Kategori...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">STOK AWAL *</label>
                <input type="number" name="stok" min="0" placeholder="Jumlah stok barang" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-slate-800 focus:outline-none" required>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">KONDISI BARANG *</label>
                <select name="kondisi" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-slate-800 focus:outline-none" required>
                    <option value="Baik">Baik</option>
                    <option value="Rusak Ringan">Rusak Ringan</option>
                    <option value="Rusak Berat">Rusak Berat</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">FOTO FISIK ALAT (OPSIONAL)</label>
                <input type="file" name="foto" accept="image/*" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-xs text-slate-500 focus:outline-none">
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" onclick="toggleModal()" class="px-5 py-2 rounded-xl border border-slate-200 text-slate-600 text-xs font-bold uppercase hover:bg-slate-50 transition">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-[#111827] text-white text-xs font-bold uppercase hover:bg-slate-800 transition">Simpan Barang</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleModal() {
        const modal = document.getElementById('modalTambah');
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
    }
</script>
@endsection