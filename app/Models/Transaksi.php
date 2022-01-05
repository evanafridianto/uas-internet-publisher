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
        'id_barang', 'id_pembeli', 'tanggal', 'keterangan'
    ];

    // relasi antara tb transaksi ke tb barang
    public function barang()
    {
        return $this->belongsTo('App\Models\Barang');
    }
    // relasi antara tb transaksi ke tb pembeli
    public function pembeli()
    {
        return $this->belongsTo('App\Models\Pembeli');
    }
}