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
                data: "nama_pembeli",
                name: "nama_pembeli",
            },
            {
                data: "nama_barang",
                name: "nama_barang",
            },
            {
                data: "jumlah",
                name: "jumlah",
            },
            {
                data: "harga",
                name: "harga",
            },
            {
                data: "tanggal",
                name: "tanggal",
            },
            {
                data: "keterangan",
                name: "keterangan",
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

function detail_barang(id) {
    $.ajax({
        url: "barang/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="harga"]').val(data.harga);
            $('[name="stok"]').val(data.stok);
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

//reload datatable ajax
function reload_table() {
    table.ajax.reload(null, false);
}

// add
function add_transaksi() {
    const t = new Date();
    const date = ("0" + t.getDate()).slice(-2);
    const month = ("0" + (t.getMonth() + 1)).slice(-2);
    const year = t.getFullYear();
    let today = year + "-" + month + "-" + date;
    $('[name="tanggal"]').val(today);

    $(".text-danger").empty(); // clear error string
    $("#transaksi_modal").modal("show"); // show bootstrap modal
    $(".modal-title").text("Transaksi Baru"); // Set Title to Bootstrap modal title
    $(".add-data").val(""); // reset form on modals
    $('[name="id_transaksi"]').val("");
}
// edit
function edit_transaksi(id) {
    $(".text-danger").empty(); // clear error string
    $("#transaksi_modal").modal("show"); // show bootstrap modal
    $(".modal-title").text("Edit Data"); // Set title to Bootstrap modal title
    $("#transaksi_form")[0].reset(); // reset form on modals
    //Ajax Load data from ajax
    $.ajax({
        url: "transaksi/edit/" + id,
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
        url: "transaksi/save",
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
function delete_transaksi(id) {
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
                url: "transaksi/delete/" + id,
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