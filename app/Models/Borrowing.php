<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'inventory_id',
        'jumlah',
        'tgl_pinjam',
        'rencana_tgl_kembali',
        'keterangan',
        'status',
        'tgl_kembali_aktual',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}