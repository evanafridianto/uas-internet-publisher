<?php

namespace App\Http\Controllers;

use App\Models\Pembeli;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class PembeliController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'title'  => 'Data Pembeli'
        ];
        if ($request->ajax()) {
            $data = Pembeli::orderBy('id_pembeli', 'asc')
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="text-center"><button type="button" class="btn btn-success btn-sm" onclick="edit_pembeli(' . $row->id_pembeli . ')">Edit</button>
                           <button type="button" class="btn btn-danger  btn-sm" onclick="delete_pembeli(' . $row->id_pembeli . ')">Hapus</button></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.pages.datamaster.pembeli', $data);
    }

    public function edit($id)
    {
        $data = Pembeli::find($id);
        return response()->json($data);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pembeli' => 'required',
            'jk' => 'required',
            'no_telp' => 'required|numeric',
            'alamat' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        };
        Pembeli::updateOrCreate(
            [
                'id_pembeli' => $request->id_pembeli
            ],
            [
                'nama_pembeli' => $request->nama_pembeli,
                'jk' => $request->jk,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat
            ]
        );
        return response()->json(['status' => true]);
    }

    public function delete($id)
    {
        Pembeli::find($id)->delete();
        return response()->json(['status' => true]);
    }
}