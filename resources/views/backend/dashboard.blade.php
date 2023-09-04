@extends('layouts.backend')

@section('title')
    Dashboard
@endsection

@section('title_main')
    Dashboard
@endsection

@section('breadcrumb_item')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-12">
                <div class="card info-card sales-card">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            Total Data Transaksi
                        </h5>
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-database"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ 0 }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        $(document).ready(function() {


        });
    </script>
@endpush
