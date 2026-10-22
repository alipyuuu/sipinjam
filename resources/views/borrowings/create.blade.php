@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')
@section('subtitle', 'Pilih barang inventaris dan isi formulir permohonan peminjaman')

@section('content')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 max-w-4xl">
    <div class="mb-6">
        <h3 class="font-bold text-slate-800 text-base">Formulir Permohonan Peminjaman</h3>
        <p class="text-xs text-slate-400">Pastikan stok barang tersedia sebelum mengajukan</p>
    </div>

    <form action="{{ route('borrowing.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-2">PILIH BARANG INVENTARIS *</label>
                <select name="inventory_id" id="inventory_id" onchange="updatePreview(this)" class="...">
    <option value="" data-image="{{ asset('images/logo.png') }}">-- Pilih Barang --</option>
    @forelse($inventories as $item)
        <option value="{{ $item->id }}" data-image="{{ $item->foto ? asset('storage/' . $item->foto) : asset('images/logo.png') }}">
            {{ $item->nama_alat }} (Tersedia: {{ $item->stok }} Unit)
        </option>
    @empty
        <option value="" disabled>Tidak ada barang yang bisa dipinjam</option>
    @endforelse
</select>

<!-- Kotak Pratinjau Foto Barang -->
<div class="mt-3 flex items-center space-x-3 p-3 bg-slate-50 rounded-xl border border-slate-200">
    <img id="item-preview" src="{{ asset('images/logo.png') }}" class="w-12 h-12 object-cover rounded-lg border border-slate-200 shrink-0">
    <div>
        <p class="text-xs font-bold text-slate-700" id="item-name">Pratinjau Barang</p>
        <p class="text-[10px] text-slate-400">Pilih barang di atas untuk melihat gambarnya</p>
    </div>
</div>

<!-- Script Otomatis Ganti Foto -->
<script>
function updatePreview(select) {
    const selectedOption = select.options[select.selectedIndex];
    const imageUrl = selectedOption.getAttribute('data-image');
    
    if (select.value) {
        document.getElementById('item-preview').src = imageUrl;
        document.getElementById('item-name').innerText = selectedOption.text;
    } else {
        document.getElementById('item-preview').src = "{{ asset('images/logo.png') }}";
        document.getElementById('item-name').innerText = "Pratinjau Barang";
    }
}
</script>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-2">JUMLAH PINJAM *</label>
                <input type="number" name="jumlah" min="1" placeholder="Contoh: 1" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-slate-800 focus:outline-none" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-2">TANGGAL PINJAM *</label>
                <input type="date" name="tgl_pinjam" value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-slate-800 focus:outline-none" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-2">RENCANA TANGGAL KEMBALI *</label>
                <input type="date" name="rencana_tgl_kembali" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-slate-800 focus:outline-none" required>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-600 uppercase mb-2">KETERANGAN / KEPERLUAN *</label>
            <textarea name="keterangan" rows="4" placeholder="Jelaskan tujuan penggunaan barang..." class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-slate-800 focus:outline-none" required></textarea>
        </div>

        <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
            <a href="{{ route('dashboard') }}" class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-bold uppercase hover:bg-slate-50 transition">BATAL</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#111827] text-white text-xs font-bold uppercase hover:bg-slate-800 transition">KIRIM PENGAJUAN</button>
        </div>
    </form>
</div>
@endsection