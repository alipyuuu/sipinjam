@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Edit Data Inventaris</h2>
                <p class="text-xs text-slate-400">Perbarui informasi barang dan dokumen foto inventaris</p>
            </div>
            <a href="{{ route('inventaris.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-700 transition">
                &larr; Kembali
            </a>
        </div>

        <!-- Form Edit -->
        <form action="{{ route('inventaris.update', $inventory->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Preview & Upload Foto -->
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Foto Barang</label>
                <div class="flex items-center space-x-4 p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <img id="img-preview" 
                         src="{{ $inventory->foto ? asset('storage/' . $inventory->foto) : asset('images/logo.png') }}" 
                         alt="Pratinjau Foto" 
                         class="w-16 h-16 object-cover rounded-xl border border-slate-200 shrink-0">
                    <div class="w-full">
                        <input type="file" name="foto" id="foto" accept="image/*" onchange="previewImage(event)" 
                               class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer">
                        <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG, WEBP (Maksimal 2MB)</p>
                    </div>
                </div>
                @error('foto')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Barang / Alat -->
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Nama Barang / Alat *</label>
                <input type="text" name="nama_alat" value="{{ old('nama_alat', $inventory->nama_alat) }}" required 
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-teal-500 focus:outline-none">
                @error('nama_alat')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori & Stok -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Kategori -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Kategori *</label>
                    <select name="category_id" required 
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-teal-500 focus:outline-none">
                        <option value="" disabled>-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $inventory->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori ?? $category->name ?? $category->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Stok Barang *</label>
                    <input type="number" name="stok" min="0" value="{{ old('stok', $inventory->stok) }}" required 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    @error('stok')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Kondisi Barang -->
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Kondisi *</label>
                <select name="kondisi" required 
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs text-slate-700 focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    <option value="Baik" {{ old('kondisi', $inventory->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak Ringan" {{ old('kondisi', $inventory->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="Rusak Berat" {{ old('kondisi', $inventory->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>
                @error('kondisi')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="pt-4 flex justify-end space-x-2 border-t border-slate-100">
                <a href="{{ route('inventaris.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-200 transition">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2.5 bg-teal-600 text-white rounded-xl text-xs font-bold hover:bg-teal-700 shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script Live Preview Foto -->
<script>
function previewImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('img-preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection