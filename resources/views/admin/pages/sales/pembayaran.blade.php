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

                            </select>
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Nama Pembeli</label>
                            <select class="form-control" name="id_pembeli">
                                <option value="">--Pilih Pembeli--</option>

                            </select>
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" class="form-control input-default" name="jumlah"
                                placeholder="Masukkan Jumlah">
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
    {{-- <script src="{{ asset('crud.js/transaksi.js') }}"></script> --}}
    <script>
        var table;

        $(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            table = $("#datatable").DataTable({
                processing: true,
                serverSide: true,
                ajax: "",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "id_transaksi",
                        name: "id_transaksi",
                    },
                    {
                        data: "tanggal",
                        name: "tanggal",
                    },
                    {
                        data: "tgl_bayar",
                        name: "tgl_bayar",
                    },
                    {
                        data: "total_bayar",
                        name: "total_bayar",
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });

            //set input/select event when change value, remove class error and remove text text-danger
            $("input").change(function() {
                $(this).next().empty();
            });

            $("select").change(function() {
                $(this).next().empty();
            });
            $("textarea").change(function() {
                $(this).next().empty();
            });

            // Date picker
            $(".datepicker").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: "yyyy-mm-dd",
                language: "id",
            });
        });

        //reload datatable ajax
        function reload_table() {
            table.ajax.reload(null, false);
        }

        // add
        function add_transaksi() {
            $(".text-danger").empty(); // clear error string
            $("#transaksi_modal").modal("show"); // show bootstrap modal
            $(".modal-title").text("Tambah Data"); // Set Title to Bootstrap modal title
            $("#transaksi_form")[0].reset(); // reset form on modals
            $('[name="id_transaksi"]').val("");
        }
        // edit
        function edit_pembayaran(id) {
            $(".text-danger").empty(); // clear error string
            $("#transaksi_modal").modal("show"); // show bootstrap modal
            $(".modal-title").text("Edit Data"); // Set title to Bootstrap modal title
            $("#transaksi_form")[0].reset(); // reset form on modals
            //Ajax Load data from ajax
            $.ajax({
                url: "pemabayaran/edit/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('[name="id_transaksi"]').val(data.id_transaksi);
                    $('[name="id_barang"]').val(data.id_barang);
                    $('[name="id_pembeli"]').val(data.id_pembeli);
                    $('[name="jumlah"]').val(data.jumlah);
                    $('[name="tanggal"]').val(data.tanggal);
                    $('[name="keterangan"]').val(data.keterangan);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal({
                        title: "Error!",
                        text: "Server error!",
                        type: "error",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(
                        function() {},
                        // handling the promise rejection
                        function(dismiss) {
                            if (dismiss === "timer") {}
                        }
                    );
                },
            });
        }

        // save
        function save_transaksi() {
            $("#btnSave").text("Menyimpan..."); //change button text
            $("#btnSave").attr("disabled", true); //set button disable
            // ajax adding data to database
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                url: "pemabayaran/save",
                type: "POST",
                data: $("#transaksi_form").serialize(),
                dataType: "JSON",
                success: function(data) {
                    $("#transaksi_modal").modal("hide");
                    swal({
                        title: "Sukses!",
                        text: "Data berhasil disimpan!",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(
                        function() {},
                        // handling the promise rejection
                        function(dismiss) {
                            if (dismiss === "timer") {}
                        }
                    );
                    //if success reload ajax table
                    reload_table();
                    $("#btnSave").text("Simpan"); //change button text
                    $("#btnSave").attr("disabled", false); //set button enable
                },
                error: function(response) {
                    if (response.status == 404) {
                        let responseData = JSON.parse(response.responseText);
                        $.each(responseData, function(key, value) {
                            $('[name="' + key + '"]')
                                .next()
                                .text(value); //select span form-text class set text error string
                        });
                    } else {
                        swal({
                            title: "Error!",
                            text: "Server error!",
                            type: "error",
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(
                            function() {},
                            // handling the promise rejection
                            function(dismiss) {
                                if (dismiss === "timer") {}
                            }
                        );
                    }
                    $("#btnSave").text("Simpan"); //change button text
                    $("#btnSave").attr("disabled", false); //set button enable
                },
            });
        }

        // delete
        function delete_pembayaran(id) {
            swal({
                title: "Anda yakin?",
                text: "Data akan dihapus permanen!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4fa7f3",
                cancelButtonColor: "#d57171",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                confirmButtonClass: "btn btn-danger",
                cancelButtonClass: "btn btn-default m-l-10",
                buttonsStyling: false,
            }).then(
                function() {
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                    });
                    $.ajax({
                        url: "pembayaran/delete/" + id,
                        type: "DELETE",
                        dataType: "JSON",
                        success: function(data) {
                            swal({
                                title: "Sukses!",
                                text: "Data berhasil dihapus!",
                                type: "success",
                                showConfirmButton: false,
                                timer: 1500,
                            }).then(
                                function() {},
                                // handling the promise rejection
                                function(dismiss) {
                                    if (dismiss === "timer") {}
                                }
                            );
                            //if success reload ajax table
                            reload_table();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            swal({
                                title: "Gagal!",
                                text: "Proses gagal!",
                                type: "error",
                                showConfirmButton: false,
                                timer: 1500,
                            }).then(
                                function() {},
                                // handling the promise rejection
                                function(dismiss) {
                                    if (dismiss === "timer") {}
                                }
                            );
                        },
                    });
                },
                function(dismiss) {
                    // dismiss can be 'cancel', 'overlay',
                    // 'close', and 'timer'
                    if (dismiss === "cancel") {
                        if (dismiss === "timer") {}
                    }
                }
            );
        }
    </script>
@endsection
