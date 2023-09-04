@extends('layouts.backend')

@section('title')
    {{ $mode }} Data Transaksi
@endsection

@section('title_main')
    {{ $mode }} Data Transaksi
@endsection

@section('breadcrumb_item')
    <li class="breadcrumb-item active">{{ $mode }} Data Transaksi</li>
@endsection

@push('after-styles')
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form id="formSaveTransaksi"
                    action="{{ $mode == 'Input' ? route($saveRoute) : route($saveRoute, request()->route('id')) }}"
                    class="needs-validation" novalidate method="{{ $mode == 'Input' ? 'POST' : 'POST' }}">
                    @csrf
                    <div class="card-body">
                        <div class="card-title">
                            <h2 class="fw-bold">{{ $mode }} Data Transaksi</h2>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-2">
                                        <label for="">Description</label>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea class="form-control" rows="3" placeholder="Description" name="description" id="description" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <div class="col-2">
                                        <label for="">Code</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" class="form-control" placeholder="Code" name="code"
                                            id="code" required>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-2">
                                        <label for="">Rate Euro</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" class="form-control" placeholder="Rate Euro" name="rate_euro"
                                            id="rate_euro" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <label for="">Date Paid</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" class="form-control datepicker" placeholder="Date Paid"
                                            name="date_paid" id="date_paid" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card m-5">
                            <h3 class="py-4 text-danger text-center" id="warningSaveTransaksi">
                                Transaksi Belum di Tambahkan
                            </h3>
                            <div class="card-body">
                                <div class="card-title m-3">
                                    Data Transaksi
                                </div>
                                <div id="containerTransaksi">
                                </div>
                                <div class="text-center my-5">
                                    <div class="d-inline">
                                        <button type="button" class="btn btn-primary rounded-circle" id="btnAddCategory">
                                            <i class="bi bi-plus" style="font-size: 20px;"></i>
                                        </button>
                                        <span class="d-block mt-2 fw-bold">
                                            Tambah Kategori
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="transaksi_detail" id="transaksiDetail">
                                <div class="d-block float-end">
                                    <button type="submit" class="btn btn-primary" id="btnSimpan">
                                        {{ $mode == 'Input' ? 'Simpan' : 'Update' }}
                                    </button>
                                    <button type="button" class="btn btn-danger">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script type="text/javascript">
        let categories = []
        var countCategories = 0

        function itemCategory(number) {
            return ` <div class="card mx-4" id="itemCategory${number}">
                        <div class="position-relative">
                            <div class="position-absolute top-0 end-0">
                                <a href="#" class="" aria-label="close" id="btnDeleteCategory" onclick="deleteCategory(${number})">
                                    <i class="bi bi-x fw-bold" style="font-size: 50px; color: red;"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row mt-3">
                                <div class="col-2">
                                    <label class="form-label">Category</label>
                                </div>
                                <div class="col-8">
                                    <div class="w-25">
                                        <select id="category${number}" placeholder="Input Category"
                                            class="form-select">
                                            <option disabled selected value="">Pilih Category</option>
                                            @foreach ($category as $p)
                                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-10">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered" id="tbl-transaksi${number}">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama Transaksi</th>
                                                            <th>Nominal (IDR)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-11">
                                            <div class="d-flex align-items-center">
                                                <input type="text" placeholder="Masukkan Nama Transaksi"
                                                    class="form-control me-2 transaksi"
                                                    id="namaTransaksi${number}">
                                                <input type="text" placeholder="Masukkan Nominal"
                                                    class="form-control number me-4 transaksi" id="nominal${number}">
                                                <button type="button" class="btn btn-primary rounded-circle"
                                                    id="btnAddTransaksi" onclick="addTransaksi(${number})">
                                                    <i class="bi bi-plus" style="font-size: 20px;"></i>
                                                </button>
                                            </div>
                                            <p class="text-danger text-center" id="warningAddTransaksi${number}">
                                                Category, Nama Transaksi dan Nominal Harus di isi
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
        }


        $(document).ready(function() {
            $("#warningSaveTransaksi").hide()

            var data = {!! json_encode($data) !!};
            if (data) {
                //console.log(data)
                $("#description").text(data.description)
                $("#code").val(data.code)
                $("#rate_euro").val(data.rate_euro)
                $("#date_paid").val(data.date_paid)

                const items = data.detail
                if (items.length > 0) {
                    //initialing data for easy append
                    categories.push({
                        category: items[0].category_id,
                        items: [{
                            id: items[0].id,
                            nama: items[0].nama_transaksi,
                            nominal: items[0].nominal
                        }]
                    })

                    for (let index = 1; index < items.length; index++) {
                        const item = items[index];
                        categories[categories.findIndex(el => el.category == item.category_id)]
                            .items
                            .push({
                                id: item.id,
                                nama: item.nama_transaksi,
                                nominal: item.nominal
                            })
                    }

                    //console.log('ca', categories)

                    for (let index = 0; index < categories.length; index++) {
                        const element = categories[index]
                        const items = element.items

                        $('#containerTransaksi').append(itemCategory(index))
                        $(`#warningAddTransaksi${index}`).hide()
                        $(`#category${index}`).val(element.category)

                        for (let j = 0; j < items.length; j++) {
                            const item = items[j];
                            $(`#namaTransaksi${index}`).val(item.nama)
                            $(`#nominal${index}`).val(item.nominal)
                            $(`#tbl-transaksi${index} tbody:last-child`).append(
                                `<tr>
                                    <td>${$(`#namaTransaksi${index}`).val()}</td>
                                    <td>${$(`#nominal${index}`).val()}</td>
                                </tr>`
                            )
                        }

                        $(`#namaTransaksi${index}`).val('')
                        $(`#nominal${index}`).val('')
                    }


                    countCategories = items.length - 1;
                }
            }
        });

        $('#btnAddCategory').on('click', () => {
            $("#warningSaveTransaksi").hide()
            $('#containerTransaksi').append(itemCategory(countCategories))
            $(`#warningAddTransaksi${countCategories}`).hide()
            countCategories++
        })

        function deleteCategory(index) {
            if (categories.indexOf(index) > -1) {
                categories.splice(categories.indexOf(index), 1)
            }
            $(`#itemCategory${index}`).remove()
        }

        function addTransaksi(index) {
            const category = $(`#category${index}`).val()
            const nama = $(`#namaTransaksi${index}`).val()
            const nominal = $(`#nominal${index}`).val()

            console.log('ca', category)
            if (nama != '' && nominal != '' && (category != null && category != '')) {
                $(`#warningAddTransaksi${index}`).hide()
                $(`#tbl-transaksi${index} tbody:last-child`).append(
                    `<tr>
                        <td>${$(`#namaTransaksi${index}`).val()}</td>
                        <td>${$(`#nominal${index}`).val()}</td>
                    </tr>`
                )

                const item = {
                    id: null,
                    nama: nama,
                    nominal: nominal
                }

                if (categories.length > 0 && categories.filter((e) => e.category == category).length > 0) {
                    categories[categories.findIndex(el => el.category == category)].items.push(item)
                } else {
                    categories.push({
                        category: category,
                        items: [item]
                    })
                }


                $(`#namaTransaksi${index}`).val('')
                $(`#nominal${index}`).val('')

                return false;
            } else {
                $(`#warningAddTransaksi${index}`).show()
            }
        }

        $('#formSaveTransaksi').submit(function(evenet) {
            $(`#transaksiDetail`).val(JSON.stringify(categories))
            //console.log('save', $('#formSaveTransaksi').serialize())
            //return false
            if (categories.length == 0) {
                $("#warningSaveTransaksi").show()
                return false
            } else {
                //$(`#transaksiDetail`).val(JSON.stringify(categories))
                return true
            }
        })

        function addTblTransaksi() {

        }
    </script>
@endpush
