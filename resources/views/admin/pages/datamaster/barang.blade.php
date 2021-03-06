@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $title }}</h4>
                </div>
                <div class="card-body ">
                    <button type="button" class="btn btn-primary" onclick="add_barang()">+ Tambah Data</button>
                    <button type="button" class="btn btn-info" onclick="reload_table()">Reload Tabel</button>
                    <hr>
                    <div class="table-responsive">
                        <table id="datatable" class="display" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Supplier</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="barang_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="barang_form">
                    <div class="modal-body">
                        <input type="hidden" class="form-control input-default" name="id_barang">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control input-default" name="nama_barang"
                                placeholder="Masukkan Nama Barang">
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Harga (Rp)</label>
                            <input type="text" class="form-control input-default" name="harga" placeholder="Masukkan Harga">
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="text" class="form-control input-default" name="stok" placeholder="Masukkan Stok">
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Supplier</label>
                            <select class="form-control" name="id_supplier">
                                <option value="">--Pilih Supplier--</option>
                                @foreach ($supplier as $list)
                                    <option value="{{ $list->id_supplier }}">{{ $list->nama_supplier }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btnSave" onclick="save_barang()">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('crud.js/barang.js') }}"></script>
@endsection
