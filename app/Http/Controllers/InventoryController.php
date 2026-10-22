<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::with('category');

        if ($request->filled('search')) {
            $query->where('nama_alat', 'like', '%' . $request->search . '%');
        }

        $inventories = $query->latest()->paginate(10);
        $categories = Category::all();

        return view('inventories.index', compact('inventories', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alat'   => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stok'        => 'required|integer|min:0',
            'kondisi'     => 'required|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('inventories', 'public');
        }

        Inventory::create([
            'nama_alat'   => $request->nama_alat,
            'category_id' => $request->category_id,
            'stok'        => $request->stok,
            'kondisi'     => $request->kondisi,
            'foto'        => $fotoPath,
        ]);

        return redirect()->route('inventaris.index')->with('success', 'Barang inventaris berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);
        $categories = Category::all();

        return view('inventories.edit', compact('inventory', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $request->validate([
            'nama_alat'   => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stok'        => 'required|integer|min:0',
            'kondisi'     => 'required|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $fotoPath = $inventory->foto;

        if ($request->hasFile('foto')) {
            // Hapus foto lama dari storage jika ada
            if ($inventory->foto && Storage::disk('public')->exists($inventory->foto)) {
                Storage::disk('public')->delete($inventory->foto);
            }

            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('inventories', 'public');
        }

        $inventory->update([
            'nama_alat'   => $request->nama_alat,
            'category_id' => $request->category_id,
            'stok'        => $request->stok,
            'kondisi'     => $request->kondisi,
            'foto'        => $fotoPath,
        ]);

        return redirect()->route('inventaris.index')->with('success', 'Barang inventaris berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);

        if ($inventory->foto && Storage::disk('public')->exists($inventory->foto)) {
            Storage::disk('public')->delete($inventory->foto);
        }

        $inventory->delete();

        return redirect()->route('inventaris.index')->with('success', 'Barang inventaris berhasil dihapus!');
    }
}