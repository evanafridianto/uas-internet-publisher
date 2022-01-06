@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $title }}</h4>
                </div>
                <div class="card-body ">
                    <button type="button" class="btn btn-primary" onclick="add_transaksi()">+ Transaksi Baru</button>
                    <button type="button" class="btn btn-info" onclick="reload_table_trns()">Reload Tabel</button>
                    <hr>
                    <div class="table-responsive">
                        <table id="datatable" class="display" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pembeli</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
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
    <div class="modal fade bd-example-modal-lg" id="transaksi_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="transaksi_form">
                    <div class="modal-body">
                        <input type="hidden" class="form-control input-default" name="id_transaksi">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Transaksi</label>
                                    <input name="tanggal" class="datepicker form-control" readonly
                                        placeholder="Masukkan Tanggal">
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Pembeli</label>
                                    <select class="form-control add-data" name="id_pembeli">
                                        <option value="">--Pilih Pembeli--</option>
                                        @foreach ($pembeli as $list)
                                            <option value="{{ $list->id_pembeli }}">{{ $list->nama_pembeli }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <select class="form-control add-data"
                                        onchange="detail_barang(this.options[this.selectedIndex].value)" name="id_barang">
                                        <option value="">--Pilih Barang--</option>
                                        @foreach ($barang as $list)
                                            <option value="{{ $list->id_barang }}">{{ $list->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <input type="number" class="form-control add-data input-default" min="1" value="1"
                                        name="jumlah" placeholder="Masukkan Jumlah">
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-warning">Harga Satuan (Rp)</label>
                                    <input type="text" disabled class="form-control add-data input-default" name="harga"
                                        placeholder="Harga Satuan">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-warning">Stok</label>
                                    <input type="text" disabled class="form-control add-data input-default" name="stok"
                                        placeholder="Stok">
                                </div>
                            </div>
                        </div>
                        <select class="form-control" style="display: none" name="keterangan">
                            <option value="Belum Dibayar">Belum Dibayar</option>
                            <option value="Dibayar">Dibayar</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btnSave" onclick="save_transaksi()">Simpan<span
                                class="btn-icon-right"><i class="fa fa-cart-plus"></i></span></button>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('crud.js/transaksi.js') }}"></script>
@section('form_pembayaran')
    @include('admin.pages.sales.form_pembayaran')
@show
@endsection
