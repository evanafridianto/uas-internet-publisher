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
            $data = Pembayaran::leftJoin('transaksi', 'transaksi.id_transaksi', '=', 'pembayaran.id_transaksi')
                ->orderBy('id_pembayaran', 'asc')
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="text-center"><button type="button" class="btn btn-success btn-sm" onclick="edit_pembayaran(' . $row->id_pembayaran . ')">Edit</button>
                           <button type="button" class="btn btn-danger  btn-sm" onclick="delete_pembayaran(' . $row->id_pembayaran . ')">Hapus</button></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.pages.sales.pembayaran', $data);
    }

    public function edit($id)
    {
        $data = Pembayaran::find($id);
        return response()->json($data);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_barang' => 'required',
            'id_pembeli' => 'required',
            'jumlah' => 'required',
            'tanggal' => 'required',
            'keterangan' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        };
        Pembayaran::updateOrCreate(
            [
                'id_transaksi' => $request->id_transaksi
            ],
            [
                'id_barang' => $request->id_barang,
                'id_pembeli' => $request->id_pembeli,
                'jumlah' => $request->jumlah,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan
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