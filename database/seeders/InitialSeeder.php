<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Hash;

class InitialSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Petugas
        $petugas = User::create([
            'name' => 'Admin Sekolah',
            'nis_nip' => '198501012010011001',
            'email' => 'petugas@smkn5surakarta.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'petugas'
        ]);

        // Akun Siswa
        $siswa = User::create([
            'name' => 'Favian Alifka Hantoro',
            'nis_nip' => '220013',
            'email' => 'favian@siswa.smkn5surakarta.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'siswa'
        ]);

        // Kategori Data
        $elektronik = Category::create(['nama_kategori' => 'Elektronik']);
        $audio = Category::create(['nama_kategori' => 'Audio']);
        $perlengkapan = Category::create(['nama_kategori' => 'Perlengkapan']);

        // Data Inventaris
        $inv1 = Inventory::create(['category_id' => $elektronik->id, 'nama_alat' => 'Proyektor Epson EB-X41', 'stok' => 4, 'kondisi' => 'Baik']);
        $inv2 = Inventory::create(['category_id' => $elektronik->id, 'nama_alat' => 'Laptop Asus VivoBook', 'stok' => 8, 'kondisi' => 'Baik']);
        $inv3 = Inventory::create(['category_id' => $audio->id, 'nama_alat' => 'Mikrofon Shure SM58', 'stok' => 6, 'kondisi' => 'Baik']);
        $inv4 = Inventory::create(['category_id' => $elektronik->id, 'nama_alat' => 'Kamera DSLR Canon EOS', 'stok' => 2, 'kondisi' => 'Rusak Ringan']);
        $inv5 = Inventory::create(['category_id' => $audio->id, 'nama_alat' => 'Speaker Aktif JBL 15"', 'stok' => 3, 'kondisi' => 'Baik']);

        // Data Sampel Peminjaman dari Siswa ke Petugas
        Borrowing::create([
            'user_id' => $siswa->id,
            'inventory_id' => $inv1->id,
            'jumlah' => 1,
            'tgl_pinjam' => now()->toDateString(),
            'rencana_tgl_kembali' => now()->addDays(3)->toDateString(),
            'keterangan' => 'Keperluan Presentasi Tugas Akhir',
            'status' => 'Pending',
        ]);

        Borrowing::create([
            'user_id' => $siswa->id,
            'inventory_id' => $inv3->id,
            'jumlah' => 2,
            'tgl_pinjam' => now()->subDays(2)->toDateString(),
            'rencana_tgl_kembali' => now()->addDays(1)->toDateString(),
            'keterangan' => 'Kegiatan Ekstrakurikuler Musik',
            'status' => 'Approved',
        ]);
    }
}