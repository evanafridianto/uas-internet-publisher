<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'title'  => 'Data Pembayaran',
        ];
        if ($request->ajax()) {
            $data = Pembayaran::with('transaksi')
                ->orderBy('id_pembayaran', 'asc')
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="text-center">
                           <button type="button" class="btn btn-danger  btn-sm" onclick="delete_pembayaran(' . $row->id_pembayaran . ')">Hapus</button></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.pages.sales.pembayaran', $data);
    }


    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tgl_bayar' => 'required',
            'total_bayar' => 'required',
            'id_transaksi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        };

        Pembayaran::updateOrCreate(
            [
                'id_pembayaran' => $request->id_pembayaran
            ],
            [
                'tgl_bayar' => $request->tgl_bayar,
                'total_bayar' => $request->total_bayar,
                'id_transaksi' => $request->id_transaksi
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