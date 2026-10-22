<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'petugas') {
            $totalInventaris = Inventory::sum('stok');
            $sedangDipinjam = Borrowing::where('status', 'Approved')->sum('jumlah');
            $peminjamanBulanIni = Borrowing::whereMonth('created_at', now()->month)->count();
            $terlambatKembali = Borrowing::where('status', 'Approved')
                ->where('rencana_tgl_kembali', '<', now())
                ->count();

            $statusTersedia = Inventory::where('kondisi', 'Baik')->sum('stok');
            $statusDipinjam = $sedangDipinjam;
            $statusRusak = Inventory::where('kondisi', '!=', 'Baik')->sum('stok');

            $aktivitasTerbaru = Borrowing::with(['user', 'inventory'])->latest()->take(5)->get();
        } else {
            // Dashboard Spesifik Siswa
            $totalInventaris = Inventory::sum('stok');
            $sedangDipinjam = Borrowing::where('user_id', $user->id)->where('status', 'Approved')->sum('jumlah');
            $peminjamanBulanIni = Borrowing::where('user_id', $user->id)->whereMonth('created_at', now()->month)->count();
            $terlambatKembali = Borrowing::where('user_id', $user->id)->where('status', 'Approved')
                ->where('rencana_tgl_kembali', '<', now())
                ->count();

            $statusTersedia = Inventory::where('kondisi', 'Baik')->sum('stok');
            $statusDipinjam = $sedangDipinjam;
            $statusRusak = Inventory::where('kondisi', '!=', 'Baik')->sum('stok');

            $aktivitasTerbaru = Borrowing::with(['user', 'inventory'])
                ->where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard', compact(
            'totalInventaris',
            'sedangDipinjam',
            'peminjamanBulanIni',
            'terlambatKembali',
            'statusTersedia',
            'statusDipinjam',
            'statusRusak',
            'aktivitasTerbaru'
        ));
    }
}