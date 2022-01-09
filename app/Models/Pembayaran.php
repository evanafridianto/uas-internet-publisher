<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable =  [
        'kode_transaksi', 'tgl_bayar', 'total_bayar', 'id_transaksi'
    ];

    // relasi antara tb pembayaran ke tb transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'kode_transaksi', 'kode_transaksi');
        // return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}