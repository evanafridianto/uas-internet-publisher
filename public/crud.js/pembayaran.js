var table;

$(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    table = $("#datatable_pemb").DataTable({
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

// add pembayaran from transaksi
function add_pembayaran(id) {
    const t = new Date();
    const date = ("0" + t.getDate()).slice(-2);
    const month = ("0" + (t.getMonth() + 1)).slice(-2);
    const year = t.getFullYear();
    let today = year + "-" + month + "-" + date;
    $('[name="tgl_bayar"]').val(today);

    $('[name="id_pembayaran"]').val("");
    $(".text-danger").empty(); // clear error string
    $("#pembayaran_modal").modal("show"); // show bootstrap modal
    $(".modal-title").text("Detail Pembayaran"); // Set Title to Bootstrap modal title
    $.ajax({
        url: "pembayaran/detail_bayar/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            let total = data.jumlah * data.harga;
            $('[name="id_transaksi"]').val(data.id_transaksi);
            $('[name="id_barang"]').val(data.id_barang);
            $('[name="id_pembeli"]').val(data.id_pembeli);
            $('[name="harga"]').val(data.harga);
            $('[name="jumlah"]').val(data.jumlah);

            $('[name="total_bayar"]').val(total);
        },
    });
}

// save
function save_pembayaran() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    $("#btnKonfir").text("Menyimpan..."); //change button text
    $("#btnKonfir").attr("disabled", true); //set button disable
    // ajax adding data to database
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: "pembayaran/save",
        type: "POST",
        data: $("#pembayaran_form").serialize(),
        dataType: "JSON",
        success: function(data) {
            $("#pembayaran_modal").modal("hide");
            swal({
                title: "Sukses!",
                text: "Data penjualan berhasil disimpan!",
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
            $.ajax({
                url: "transaksi/edit_ket",
                type: "POST",
                dataType: "JSON",
                data: {
                    _token: CSRF_TOKEN,
                    id_transaksi: $('[name="id_transaksi"]').val(),
                },
                success: function(response) {},
            });
            reload_table_trns();
            reload_table();
            $("#btnKonfir").text("Konfirmasi"); //change button text
            $("#btnKonfir").attr("disabled", false); //set button enable
        },
        error: function(response) {
            if (response.status == 404) {
                let responseData = JSON.parse(response.responseText);
                $.each(responseData, function(key, value) {
                    $('[name="' + key + '"]')
                        .next()
                        .text(value); //select span form-text class set text error string
                });
            } else if (response.status == 405) {
                let responseData = JSON.parse(response.responseText);
                $.each(responseData, function(key, value) {
                    swal({
                        title: "Warning!",
                        text: value,
                        type: "warning",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(
                        function() {},
                        // handling the promise rejection
                        function(dismiss) {
                            if (dismiss === "timer") {
                                $("#pembayaran_modal").modal("hide");
                            }
                        }
                    );
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
            $("#btnKonfir").text("Konfirmasi"); //change button text
            $("#btnKonfir").attr("disabled", false); //set button enable
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