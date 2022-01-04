<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $data = [
        	'title'  => 'Data Barang',
            'supplier' => Supplier::all(),
        ];
        if ($request->ajax()) {
            $data = Barang::leftJoin('supplier', 'barang.id_supplier', '=', 'supplier.id_supplier')
            ->orderBy('id_barang', 'asc')
            ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<div class="text-center"><button type="button" class="btn btn-success btn-sm" onclick="edit_barang('.$row->id_barang.')">Edit</button>
                           <button type="button" class="btn btn-danger  btn-sm" onclick="delete_barang('.$row->id_barang.')">Hapus</button></div>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.pages.datamaster.barang',$data);
    }

    public function edit($id)
    {
        $data = Barang::find($id);
        return response()->json($data);
    }

    public function save(Request $request)
    {
        Barang::updateOrCreate(
            [
                'id_barang' => $request->id_barang
            ],
            [
                'nama_barang' => $request->nama_barang,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'id_supplier' => $request->id_supplier
            ]);
        return response()->json(['status' => true]);
    }

    public function delete($id)
    {
        Barang::find($id)->delete();
        return response()->json(['status' => true]);
    }

    private function _validate()
    {
        $data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		// if(empty($request->input('nama_barang')))
		// {
		// 	$data['inputerror'][] = 'nama_barang';
		// 	$data['error_string'][] = 'Nama Barang is required';
		// 	$data['status'] = FALSE;
		// }

		// if($this->input->post('harga') == '')
		// {
		// 	$data['inputerror'][] = 'harga';
		// 	$data['error_string'][] = 'Harga is required';
		// 	$data['status'] = FALSE;
		// }

		// if($this->input->post('stok') == '')
		// {
		// 	$data['inputerror'][] = 'stok';
		// 	$data['error_string'][] = 'Stok is required';
		// 	$data['status'] = FALSE;
		// }

		// if($this->input->post('id_suplier') == '')
		// {
		// 	$data['inputerror'][] = 'id_suplier';
		// 	$data['error_string'][] = 'Please select suplier';
		// 	$data['status'] = FALSE;
		// }

		if($data['status'] === FALSE)
		{
			// echo json_encode($data);
            return response()->json($data);
			exit();
		}
    }
}
