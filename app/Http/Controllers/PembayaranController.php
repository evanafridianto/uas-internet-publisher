<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use PDF;

class PembayaranController extends Controller
{
    // public function index(Request $request)
    // {
    //     $data = [
    //         'title'  => 'Data Pembayaran',
    //     ];
    //     if ($request->ajax()) {
    //         $data = Pembayaran::with('transaksi')
    //             ->orderBy('id_pembayaran', 'asc')
    //             ->get();
    //         return DataTables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('action', function ($row) {
    //                 $btn = '<div class="text-center">
    //                        <button type="button" class="btn btn-danger  btn-sm" onclick="delete_pembayaran(' . $row->id_pembayaran . ')">Hapus</button></div>';
    //                 return $btn;
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }
    //     return view('admin.pages.sales.pembayaran', $data);
    // }
    public function datatable(Request $request)
    {
        $data = [
            'title'  => 'Data Pembayaran',
        ];
        if ($request->ajax()) {
            $data = Pembayaran::orderBy('created_at', 'asc')
                ->with('transaksi')
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="text-center">
                           <button type="button" class="btn btn-danger  btn-sm" onclick="delete_pembayaran(' . $row->id_pembayaran . ')">Hapus</button>
                           <a target="_BLANK" href="transaksi/cetak/' . $row->transaksi->kode_transaksi . '" type="button" class="btn btn-info  btn-sm" >Cetak</a></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function save(Request $request)
    {
        Pembayaran::updateOrCreate(
            [
                'id_pembayaran' => '',
            ],
            [
                'tgl_bayar' => date('Y-m-d'),
                'total_bayar' => $request->total_bayar,
                'kode_transaksi' => $request->kode_transaksi,
            ]
        );
        return response()->json(['status' => true]);
    }

    public function delete($id)
    {
        Pembayaran::find($id)->delete();
        return response()->json(['status' => true]);
    }
}