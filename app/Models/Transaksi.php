<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $fillable =  [
        'kode_transaksi', 'id_barang', 'id_pembeli', 'jumlah', 'tanggal', 'keterangan'
    ];

    // relasi antara tb transaksi ke tb pembayaran
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    // relasi antara tb transaksi ke tb barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    // relasi antara tb transaksi ke tb pembeli
    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'id_pembeli', 'id_pembeli');
    }
}