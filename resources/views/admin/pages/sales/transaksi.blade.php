@extends('admin.layouts.main')
@section('content')


    <!--add bayar Modal -->
    <div class="modal fade" id="add_bayar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pesanan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-sm">
                            <tr>
                                <td>ID Transaksi</td>
                                <td>:</td>
                                <td>5454375</td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>:</td>
                                <td>5454375</td>
                            </tr>
                            <tr>
                                <td>Nama Pembeli</td>
                                <td>:</td>
                                <td>5454375</td>
                            </tr>
                            <tr>
                                <td>Nama Barang</td>
                                <td>:</td>
                                <td>5454375</td>
                            </tr>
                            <tr>
                                <td>Harga Satuan</td>
                                <td>:</td>
                                <td>5454375</td>
                            </tr>
                            <tr>
                                <td>Jumlah</td>
                                <td>:</td>
                                <td>5454375</td>
                            </tr>
                            <tr>
                                <td>Total Bayar</td>
                                <td>:</td>
                                <td>5454375</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Transaksi</h4>


                </div>
                <div class="card-body">
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Pembeli</label>
                                    <select class="form-control" id="id_pembeli">
                                        <option value="">--Pilih Pembeli--</option>
                                        @foreach ($pembeli as $list)
                                            <option value="{{ $list->id_pembeli }}">{{ $list->nama_pembeli }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="pilih-barang" style="display: none">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Barang</label>
                                    <select class="form-control add-data"
                                        onchange="detail_barang(this.options[this.selectedIndex].value)"
                                        name="daftar_barang">
                                        <option value="">--Tambah Barang--</option>
                                        @foreach ($barang as $list)
                                            <option value="{{ $list->id_barang }}">{{ $list->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-responsive-sm" id="tabel-beli">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Stok</th>
                                                <th class="text-center">Jumlah Beli</th>
                                                <th>Harga</th>
                                                <th>Total</th>
                                                <th>Ket</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" id="add-keterangan">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="alert alert-info solid ">TOTAL BAYAR :<h2 id="total_bayar">0</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btnSave" onclick="save_transaksi()">Bayar
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
