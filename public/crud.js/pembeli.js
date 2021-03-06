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
                data: "jk",
                name: "jk",
            },
            {
                data: "no_telp",
                name: "no_telp",
            },
            {
                data: "alamat",
                name: "alamat",
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
});

//reload datatable ajax
function reload_table() {
    table.ajax.reload(null, false);
}

// add
function add_pembeli() {
    $(".text-danger").empty(); // clear error string
    $("#pembeli_modal").modal("show"); // show bootstrap modal
    $(".modal-title").text("Tambah Data"); // Set Title to Bootstrap modal title
    $("#pembeli_form")[0].reset(); // reset form on modals
    $('[name="id_pembeli"]').val("");
}
// edit
function edit_pembeli(id) {
    $(".text-danger").empty(); // clear error string
    $("#pembeli_modal").modal("show"); // show bootstrap modal
    $(".modal-title").text("Edit Data"); // Set title to Bootstrap modal title
    $("#pembeli_form")[0].reset(); // reset form on modals
    //Ajax Load data from ajax
    $.ajax({
        url: "pembeli/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="id_pembeli"]').val(data.id_pembeli);
            $('[name="nama_pembeli"]').val(data.nama_pembeli);
            $('[name="jk"]').val(data.jk);
            $('[name="no_telp"]').val(data.no_telp);
            $('[name="alamat"]').val(data.alamat);
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
function save_pembeli() {
    $("#btnSave").text("Menyimpan..."); //change button text
    $("#btnSave").attr("disabled", true); //set button disable
    // ajax adding data to database
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: "pembeli/save",
        type: "POST",
        data: $("#pembeli_form").serialize(),
        dataType: "JSON",
        success: function(data) {
            $("#pembeli_modal").modal("hide");
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
function delete_pembeli(id) {
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
                url: "pembeli/delete/" + id,
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