<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    // use HasFactory;


    protected $table = 'barang';
    protected $primaryKey = 'id_barang';

    protected $fillable =  [
        'nama_barang', 'harga', 'stok', 'id_supplier'
    ];

    // relasi antara tb barang ke tb supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    // relasi antara tb barang ke tb transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}