@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $title }}</h4>
                </div>
                <div class="card-body ">
                    <button type="button" class="btn btn-primary" onclick="add_transaksi()">+ Tambah Data</button>
                    <button type="button" class="btn btn-info" onclick="reload_table()">Reload Tabel</button>
                    <hr>
                    <div class="table-responsive">
                        <table id="datatable" class="display" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Nama Pembeli</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Keterangan</th>
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
    <div class="modal fade" id="transaksi_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="transaksi_form">
                    <div class="modal-body">
                        <input type="hidden" class="form-control input-default" name="id_transaksi">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <select class="form-control" name="id_barang">
                                <option value="">--Pilih Barang--</option>
                                @foreach ($barang as $list)
                                    <option value="{{ $list->id_barang }}">{{ $list->nama_barang }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Nama Pembeli</label>
                            <select class="form-control" name="id_pembeli">
                                <option value="">--Pilih Pembeli--</option>
                                @foreach ($pembeli as $list)
                                    <option value="{{ $list->id_pembeli }}">{{ $list->nama_pembeli }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input name="tanggal" class="datepicker form-control" placeholder="Masukkan Tanggal">
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea class="form-control" rows="4" name="keterangan"
                                placeholder="Masukkan Keterangan"></textarea>
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btnSave"
                            onclick="save_transaksi()">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('crud.js/transaksi.js') }}"></script>
@endsection
