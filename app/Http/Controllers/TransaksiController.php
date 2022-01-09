<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pembayaran;
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
            'title'  => 'Data Transaksi',
            'barang' => Barang::all(),
            'pembeli' => Pembeli::all(),
        ];
        if ($request->ajax()) {
            $data = Transaksi::with('barang')
                ->with('pembeli')
                ->orderBy('created_at', 'asc')
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<div class="text-center"><button type="button" class="btn btn-danger  btn-sm" onclick="delete_transaksi(' . $row->id_transaksi . ')">Hapus</button></div>';
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

    public function cetak_pdf($kode)
    {
        $data = Transaksi::select('pembeli.nama_pembeli', 'pembayaran.tgl_bayar', 'pembayaran.total_bayar', 'transaksi.keterangan', 'barang.harga', 'transaksi.jumlah', 'transaksi.kode_transaksi', 'barang.nama_barang')
            ->leftJoin('barang', 'barang.id_barang', '=', 'transaksi.id_barang')
            ->leftJoin('pembeli', 'pembeli.id_pembeli', '=', 'transaksi.id_pembeli')
            ->leftJoin('pembayaran', 'pembayaran.kode_transaksi', '=', 'transaksi.kode_transaksi')
            ->where('transaksi.kode_transaksi', $kode)
            ->get();
        view()->share('data', $data);
        $pdf = PDF::loadview('admin.pages.sales.pdf_transaksi_penjualan');
        return $pdf->setPaper('a5', 'landscape')->stream("SOLAFIDE_$kode.pdf");
    }


    public function update_stok(Request $request)
    {

        foreach ($request->multi as $key => $value) {
            Barang::where('id_barang', $value->id_barang)
                ->update(['jumlah' => $value->jumlah]);
        }
        // $id_barang = Barang::select("stok")->find($request->id_barang);
        // $update = Barang::find($request->id_barang)->update(['stok' => $id_barang->stok - $request->jumlah]);
        return response()->json(['status' => true]);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'multi.*.id_pembeli' => 'required',
            'multi.*.id_barang' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        };
        foreach ($request->multi as $key => $value) {
            Transaksi::updateOrCreate($value);
        }
        return response()->json(['status' => true]);
    }

    public function delete($id)
    {
        Transaksi::find($id)->delete();
        return response()->json(['status' => true]);
    }
}