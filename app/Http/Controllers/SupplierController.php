<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'title'  => 'Data Pembeli'
        ];
        if ($request->ajax()) {
            $data = Supplier::orderBy('id_supplier', 'asc')
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="text-center"><button type="button" class="btn btn-success btn-sm" onclick="edit_supplier(' . $row->id_supplier . ')">Edit</button>
                           <button type="button" class="btn btn-danger  btn-sm" onclick="delete_supplier(' . $row->id_supplier . ')">Hapus</button></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.pages.datamaster.supplier', $data);
    }

    public function edit($id)
    {
        $data = Supplier::find($id);
        return response()->json($data);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_supplier' => 'required',
            'no_telp' => 'required|numeric',
            'alamat' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        };
        Supplier::updateOrCreate(
            [
                'id_supplier' => $request->id_supplier
            ],
            [
                'nama_supplier' => $request->nama_supplier,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat
            ]
        );
        return response()->json(['status' => true]);
    }

    public function delete($id)
    {
        Supplier::find($id)->delete();
        return response()->json(['status' => true]);
    }
}