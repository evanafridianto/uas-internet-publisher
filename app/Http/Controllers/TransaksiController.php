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
            'title'  => 'Data Transaksi',
            'barang' => Barang::all(),
            'pembeli' => Pembeli::all(),
        ];
        if ($request->ajax()) {
            $data = Transaksi::with('barang')
                ->with('pembeli')
                ->orderBy('id_transaksi', 'asc')
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<div class="text-center"><button type="button" class="btn btn-danger  btn-sm" onclick="delete_transaksi(' . $row->id_transaksi . ')">Hapus</div>';
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
        return $pdf->setPaper('a5', 'landscape')->download("transaksi_$id.pdf");
    }


    public function update_stok(Request $request)
    {
        $id_barang = Barang::select("stok")->find($request->id_barang);
        $update = Barang::find($request->id_barang)->update(['stok' => $id_barang->stok - $request->jumlah]);
        return response()->json($update);
    }

    public function save(Request $request)
    {

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