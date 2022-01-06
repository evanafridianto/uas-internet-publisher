@extends('admin.layouts.main');
@section('content');
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="stat-widget-one card-body">
                    <div class="stat-icon d-inline-block">
                        <i class="ti-package text-success border-success"></i>
                    </div>
                    <div class="stat-content d-inline-block">
                        <div class="stat-text">Total Barang</div>
                        <div class="stat-digit">{{ $barang }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="stat-widget-one card-body">
                    <div class="stat-icon d-inline-block">
                        <i class="ti-user text-primary border-primary"></i>
                    </div>
                    <div class="stat-content d-inline-block">
                        <div class="stat-text">Total Pembeli</div>
                        <div class="stat-digit">{{ $pembeli }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="stat-widget-one card-body">
                    <div class="stat-icon d-inline-block">
                        <i class="ti-hand-open text-pink border-pink"></i>
                    </div>
                    <div class="stat-content d-inline-block">
                        <div class="stat-text">Total Supplier</div>
                        <div class="stat-digit">{{ $supplier }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="stat-widget-one card-body">
                    <div class="stat-icon d-inline-block">
                        <i class="ti-shopping-cart text-danger border-danger"></i>
                    </div>
                    <div class="stat-content d-inline-block">
                        <div class="stat-text">Total Barang Terjual</div>
                        <div class="stat-digit">{{ $pembayaran }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
