<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\Pembeli;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use PDF;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'title'  => 'Transaksi',
            'barang' => Barang::all(),
            'pembeli' => Pembeli::all()
        ];
        if ($request->ajax()) {
            $data = Transaksi::leftJoin('barang', 'barang.id_barang', '=', 'transaksi.id_barang')
                ->leftJoin('pembeli', 'pembeli.id_pembeli', '=', 'transaksi.id_pembeli')
                ->orderBy('id_transaksi', 'asc')
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if ($row->keterangan == 'Dibayar') {
                        $btn = '<div class="text-center"><button type="button" class="btn btn-success btn-sm" onclick="edit_transaksi(' . $row->id_transaksi . ')">Edit</button>
                        <button type="button" class="btn btn-danger  btn-sm" onclick="delete_transaksi(' . $row->id_transaksi . ')">Hapus</button>
                        <a href="transaksi/cetak/' . $row->id_transaksi . '" class="btn btn-info  target="_BLANK" btn-sm" >Cetak</a></div>';
                    } else {

                        $btn = '<div class="text-center"><button type="button" class="btn btn-success btn-sm" onclick="edit_transaksi(' . $row->id_transaksi . ')">Edit</button>
                        <button type="button" class="btn btn-danger  btn-sm" onclick="delete_transaksi(' . $row->id_transaksi . ')">Hapus</button>
                        <button type="button" class="btn btn-warning  btn-sm" onclick="add_pembayaran(' . $row->id_transaksi . ')">Checkout</button></div>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.pages.sales.transaksi', $data);
    }

    public function edit($id)
    {
        $data = Transaksi::find($id);
        return response()->json($data);
    }

    public function cetak_pdf($id)
    {
        $data = Transaksi::leftJoin('barang', 'barang.id_barang', '=', 'transaksi.id_barang')
            ->leftJoin('pembeli', 'pembeli.id_pembeli', '=', 'transaksi.id_pembeli')
            ->find($id);

        view()->share('data', $data);
        $pdf = PDF::loadview('admin.pages.sales.pdf_transaksi_pembeli');
        return $pdf->download("transaksi_$id.pdf");
    }

    public function update_ket(Request $request)
    {
        $data = Transaksi::where('id_transaksi', $request->id_transaksi)
            ->update(['keterangan' => 'Dibayar']);
        return response()->json($data);
    }

    public function update_stok(Request $request)
    {
        $id_barang = Barang::select("stok")->find($request->id_barang);
        $update = Barang::find($request->id_barang)->update(['stok' => $id_barang->stok - $request->jumlah]);
        return response()->json($update);
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
        Transaksi::updateOrCreate(
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
        Transaksi::find($id)->delete();
        return response()->json(['status' => true]);
    }
}