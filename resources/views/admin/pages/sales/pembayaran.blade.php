@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $title }}</h4>
                </div>
                <div class="card-body ">
                    <button type="button" class="btn btn-light" onclick="cetak_pembayaran()">Print Data</button>
                    <button type="button" class="btn btn-info" onclick="reload_table()">Reload Tabel</button>
                    <hr>
                    <div class="table-responsive">
                        <table id="datatable_pemb" class="display" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Transaksi</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Total Bayar</th>
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
    <script src="{{ asset('crud.js/pembayaran.js') }}"></script>
@endsection
