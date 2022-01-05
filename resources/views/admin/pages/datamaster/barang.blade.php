@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $title }}</h4>
                </div>
                <div class="card-body ">
                    <button type="button" class="btn btn-primary" onclick="add_barang()">+ Tambah Data</button>
                    <button type="button" class="btn btn-info" onclick="reload_table()">Reload Tabel</button>
                    <hr>
                    <div class="table-responsive">
                        <table id="datatable" class="display" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Supplier</th>
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
    <div class="modal fade" id="barang_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="barang_form">
                    <div class="modal-body">
                        <input type="hidden" class="form-control input-default" name="id_barang">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control input-default" name="nama_barang"
                                placeholder="Masukkan Nama Barang">
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Harga (Rp)</label>
                            <input type="text" class="form-control input-default" name="harga" placeholder="Masukkan Harga">
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="text" class="form-control input-default" name="stok" placeholder="Masukkan Stok">
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Supplier</label>
                            <select class="form-control" name="id_supplier">
                                <option value="">--Pilih Supplier--</option>
                                @foreach ($supplier as $list)
                                    <option value="{{ $list->id_supplier }}">{{ $list->nama_supplier }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btnSave" onclick="save_barang()">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var table;

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama_barang',
                        name: 'nama_barang'
                    },
                    {
                        data: 'harga',
                        name: 'harga'
                    },
                    {
                        data: 'stok',
                        name: 'stok'
                    },
                    {
                        data: 'nama_supplier',
                        name: 'nama_supplier'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            })

            //set input/select event when change value, remove class error and remove text text-danger
            $("input").change(function() {
                $(this).next().empty();
            });

            $("select").change(function() {
                $(this).next().empty();
            });

        });

        //reload datatable ajax
        function reload_table() {
            table.ajax.reload(null, false);
        }

        // add
        function add_barang() {
            $('#barang_modal').modal('show'); // show bootstrap modal
            $('.modal-title').text('Tambah Data'); // Set Title to Bootstrap modal title
            $('#barang_form')[0].reset(); // reset form on modals
            $('[name="id_barang"]').val('');
        }
        // edit
        function edit_barang(id) {
            $('#barang_modal').modal('show'); // show bootstrap modal
            $('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title
            $('#barang_form')[0].reset(); // reset form on modals
            //Ajax Load data from ajax
            $.ajax({
                url: "barang/edit/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('[name="id_barang"]').val(data.id_barang);
                    $('[name="nama_barang"]').val(data.nama_barang);
                    $('[name="harga"]').val(data.harga);
                    $('[name="stok"]').val(data.stok);
                    $('[name="id_supplier"]').val(data.id_supplier);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal({
                        title: 'Error!',
                        text: 'Server error!',
                        type: 'error',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(
                        function() {},
                        // handling the promise rejection
                        function(dismiss) {
                            if (dismiss === 'timer') {}
                        }
                    )
                }
            });
        }

        // save
        function save_barang() {
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable
            // ajax adding data to database
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "barang/save",
                type: "POST",
                data: $('#barang_form').serialize(),
                dataType: "JSON",
                success: function(data) {

                    $('#barang_modal').modal('hide');
                    swal({
                        title: 'Sukses!',
                        text: 'Data berhasil disimpan!',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(
                        function() {},
                        // handling the promise rejection
                        function(dismiss) {
                            if (dismiss === 'timer') {}
                        }
                    )
                    //if success reload ajax table
                    reload_table();
                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable
                },
                error: function(response) {
                    if (response.status == 404) {
                        let responseData = JSON.parse(response.responseText);
                        $.each(responseData, function(key, value) {
                            $('[name="' + key + '"]').next().text(
                                value); //select span form-text class set text error string
                        });
                    } else {
                        swal({
                            title: 'Error!',
                            text: 'Server error!',
                            type: 'error',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(
                            function() {},
                            // handling the promise rejection
                            function(dismiss) {
                                if (dismiss === 'timer') {}
                            }
                        )
                    }
                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable
                }
            });
        }

        // delete
        function delete_barang(id) {
            swal({
                title: 'Anda yakin?',
                text: "Data akan dihapus permanen!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4fa7f3',
                cancelButtonColor: '#d57171',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                confirmButtonClass: 'btn btn-danger',
                cancelButtonClass: 'btn btn-default m-l-10',
                buttonsStyling: false
            }).then(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "barang/delete/" + id,
                    type: "DELETE",
                    dataType: "JSON",
                    success: function(data) {
                        swal({
                            title: 'Sukses!',
                            text: 'Data berhasil dihapus!',
                            type: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(
                            function() {},
                            // handling the promise rejection
                            function(dismiss) {
                                if (dismiss === 'timer') {}
                            }
                        )
                        //if success reload ajax table
                        reload_table();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        swal({
                            title: 'Gagal!',
                            text: 'Proses gagal!',
                            type: 'error',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(
                            function() {},
                            // handling the promise rejection
                            function(dismiss) {
                                if (dismiss === 'timer') {}
                            }
                        )
                    }
                });
            }, function(dismiss) {
                // dismiss can be 'cancel', 'overlay',
                // 'close', and 'timer'
                if (dismiss === 'cancel') {

                    if (dismiss === 'timer') {}
                }
            })
        }
    </script>
@endsection
