@extends('admin.layouts.main');
@section('content');
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-money text-success border-success"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Profit</div>
                            <div class="stat-digit">1,012</div>
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
                            <div class="stat-text">Customer</div>
                            <div class="stat-digit">961</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-layout-grid2 text-pink border-pink"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Projects</div>
                            <div class="stat-digit">770</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-link text-danger border-danger"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Referral</div>
                            <div class="stat-digit">2,781</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
