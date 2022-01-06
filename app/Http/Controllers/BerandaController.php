<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pembayaran;
use App\Models\Pembeli;
use App\Models\Supplier;

class BerandaController extends Controller
{
    //
    public function index()
    {
        $data = [
            'title'  => 'Beranda',
            'barang' => Barang::count(),
            'pembeli' => Pembeli::count(),
            'supplier' => Supplier::count(),
            'pembayaran' => Pembayaran::count(),
        ];
        return view('admin/pages/beranda', $data);
    }
}