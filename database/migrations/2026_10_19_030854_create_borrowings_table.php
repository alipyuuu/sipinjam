<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('inventory_id')->constrained('inventories')->onDelete('cascade');
            $table->integer('jumlah');
            $table->date('tgl_pinjam');
            $table->date('rencana_tgl_kembali');
            $table->date('tgl_kembali_aktual')->nullable();
            $table->text('keterangan');
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'Dikembalikan', 'Terlambat'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};