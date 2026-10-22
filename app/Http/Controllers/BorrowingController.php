<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::with(['user', 'inventory']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $borrowings = $query->latest()->paginate(10);
        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $inventories = Inventory::where('stok', '>', 0)->get();
        return view('borrowings.create', compact('inventories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'jumlah' => 'required|integer|min:1',
            'tgl_pinjam' => 'required|date',
            'rencana_tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
            'keterangan' => 'required|string',
        ]);

        $inventory = Inventory::findOrFail($request->inventory_id);
        if ($inventory->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok barang tidak mencukupi!');
        }

        Borrowing::create([
            'user_id' => Auth::id(),
            'inventory_id' => $request->inventory_id,
            'jumlah' => $request->jumlah,
            'tgl_pinjam' => $request->tgl_pinjam,
            'rencana_tgl_kembali' => $request->rencana_tgl_kembali,
            'keterangan' => $request->keterangan,
            'status' => 'Pending',
        ]);

        return redirect()->route('borrowing.history')->with('success', '🎉 Pengajuan peminjaman berhasil dikirim! Menunggu persetujuan petugas.');
    }

    public function history(Request $request)
    {
        $query = Borrowing::with('inventory')->where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $borrowings = $query->latest()->paginate(10);
        return view('borrowings.history', compact('borrowings'));
    }

    public function cancel($id)
    {
        $borrowing = Borrowing::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        if ($borrowing->status !== 'Pending') {
            return redirect()->back()->with('error', 'Pengajuan tidak dapat dibatalkan karena sudah diproses.');
        }

        $borrowing->delete();
        return redirect()->back()->with('success', 'Pengajuan peminjaman berhasil dibatalkan.');
    }

    public function approve($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->status !== 'Pending') {
            return redirect()->back()->with('error', 'Peminjaman ini sudah diproses.');
        }

        $inventory = Inventory::findOrFail($borrowing->inventory_id);
        if ($inventory->stok < $borrowing->jumlah) {
            return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
        }

        $inventory->decrement('stok', $borrowing->jumlah);
        $borrowing->update(['status' => 'Approved']);

        return redirect()->back()->with('success', 'Peminjaman disetujui & stok otomatis berkurang.');
    }

    public function reject($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->update(['status' => 'Rejected']);

        return redirect()->back()->with('success', 'Pengajuan peminjaman ditolak.');
    }

    public function returnItem($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->status !== 'Approved') {
            return redirect()->back()->with('error', 'Peminjaman belum disetujui.');
        }

        $inventory = Inventory::findOrFail($borrowing->inventory_id);
        $inventory->increment('stok', $borrowing->jumlah);

        $borrowing->update([
            'status' => 'Dikembalikan',
            'tgl_kembali_aktual' => now()
        ]);

        return redirect()->back()->with('success', 'Barang telah dikembalikan & stok berhasil dipulihkan.');
    }

    public function report(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $borrowings = Borrowing::with(['user', 'inventory'])
            ->whereBetween('tgl_pinjam', [$startDate, $endDate])
            ->latest()
            ->get();

        return view('reports.index', compact('borrowings', 'startDate', 'endDate'));
    }
}