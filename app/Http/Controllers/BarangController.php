<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'title'  => 'Data Barang',
            'supplier' => Supplier::all(),
        ];
        if ($request->ajax()) {
            $data = Barang::with('supplier')
                ->orderBy('id_barang', 'asc')
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="text-center"><button type="button" class="btn btn-success btn-sm" onclick="edit_barang(' . $row->id_barang . ')">Edit</button>
                           <button type="button" class="btn btn-danger  btn-sm" onclick="delete_barang(' . $row->id_barang . ')">Hapus</button></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.pages.datamaster.barang', $data);
    }

    public function edit($id)
    {
        $data = Barang::find($id);
        return response()->json($data);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'id_supplier' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        };
        Barang::updateOrCreate(
            [
                'id_barang' => $request->id_barang
            ],
            [
                'nama_barang' => $request->nama_barang,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'id_supplier' => $request->id_supplier
            ]
        );
        return response()->json(['status' => true]);
    }

    public function delete($id)
    {
        Barang::find($id)->delete();
        return response()->json(['status' => true]);
    }
}