@extends('layouts.backend')

@section('title')
    List Data Transaksi
@endsection

@section('title_main')
    List Data Transaksi
@endsection

@section('breadcrumb_item')
    <li class="breadcrumb-item active">List Data Transaksi</li>
@endsection

@push('after-styles')
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        List Data Transaksi
                    </div>
                    <div class="d-flex flex-wrap align-items-center justify-content-between my-3">
                        <a href="{{ route('backend.add_transaksi') }}" class="btn btn-primary">
                            Tambah Transaksi
                        </a>
                        <div class="d-flex align-items-center">
                            <input type="text" class="form-control datepicker" placeholder="Start" id="startDate"
                                name="tgl-start">
                            <span class="mx-2">to</span>
                            <input type="text" class="form-control datepicker" placeholder="End" id="endDate"
                                name="tgl-end">
                            <span class="me-2"></span>
                            <select class="form-select w-25" name="category" id="category">
                                <option selected disabled>Category</option>
                                @foreach ($category as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                            <span class="me-2"></span>
                            <input type="text" class="form-control w-25" placeholder="Search" id="search"
                                name="search">
                            <span class="me-1"></span>
                            <button class="btn btn-primary">
                                Search
                            </button>
                        </div>
                    </div>
                    <div class="divider my-3"></div>
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="datatable">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Deskripsi</th>
                                            <th>Code</th>
                                            <th>Rate Euro</th>
                                            <th>Date Paid</th>
                                            <th>Aksi</th>
                                            <!-- 10 rows -->
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
        </div>
    </div>
@endsection

@push('after-scripts')
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.gj-unselectable').removeClass('mb-3')
            $('.gj-unselectable').addClass('w-25')
        });

        let table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            responsive: true,
            "searching": false,
            responsive: true,
            "autoWidth": false,
            'language': {
                "loadingRecords": "&nbsp;",
                "processing": "Loading Data ..."
            },
            ajax: {
                url: '{{ route('backend.list_transaksi') }}',
                data: function(d) {
                    d.startDate = $('#startDate').val();
                    d.endDate = $('#endDate').val();
                    d.categoryId = $('#category').val();
                    d.search = $('#search').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: "text-center"
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'code',
                    name: 'code',
                },
                {
                    data: 'rate_euro',
                    name: 'rate_euro'
                },
                {
                    data: 'date_paid',
                    name: 'date_paid',
                },
                {
                    data: 'action',
                    name: 'action',
                    className: "text-center"
                },
            ],
            ordering: false,
            lengthChange: false,
            // oLanguage: {
            //     "sSearch": "Cari Nama Alumni"
            // }
        });

        $('#startDate').change(function() {
            if ($('#startDate').val() != '' && $('#endDate').val('')) {
                table.draw();
            }
        });

        $('#endDate').change(function() {
            if ($('#startDate').val() != '' && $('#endDate').val('')) {
                table.draw();
            }
        });

        $('#category').change(function() {
            table.draw();
        });

        $('#search').change(function() {
            table.draw();
        });
    </script>
@endpush
