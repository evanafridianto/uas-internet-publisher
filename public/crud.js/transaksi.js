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
                data: "pembeli.nama_pembeli",
                name: "pembeli.nama_pembeli",
            },
            {
                data: "barang.nama_barang",
                name: "barang.nama_barang",
            },
            {
                data: "jumlah",
                name: "jumlah",
            },
            {
                data: "barang.harga",
                name: "barang.harga",
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

// detail barang
var i = 0;

function detail_barang(id) {
    // $('[name="id_barang"]').prop("selectedIndex", 0);
    $.ajax({
        url: "barang/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            i++;

            $("#tabel-beli").append(
                "<tr><td>" +
                data.nama_barang +
                '<input name="multi[' +
                i +
                '][id_barang]" value="' +
                data.id_barang +
                '" type="hidden"><input type="hidden" name="multi[' +
                i +
                '][tanggal]" class="datepicker form-control"><input type="hidden" name="multi[' +
                i +
                '][id_pembeli]" value="' +
                $("#id_pembeli").find(":selected").val() +
                '" class="form-control"></td><td>' +
                data.stok +
                '</td><td><div class="btn-group mb-2 btn-group-sm"><button class="btn btn-light btn-min" type="button">-</button><input name="multi[' +
                i +
                '][jumlah]" class="form-control jumlah text-center" value="1" min="1"><button class="btn btn-light btn-plus" type="button">+</button></div></td><td>' +
                data.harga +
                '</td><td class="total"></td><td><input class="form-control" name="multi[' +
                i +
                '][keterangan]"></td><td><button type="button" class="btn btn-danger btn-xs remove-tr">Hapus</button></td></tr>'
            );

            $(document).on("click", ".remove-tr", function() {
                $(this).parents("tr").remove();
            });
            $(".btn-min").on("click", function(e) {
                e.preventDefault();
                var $parent = $(this).closest("tr");
                var $input = $parent.find(".jumlah");
                var $total = $parent.find(".total");
                var value = parseInt($input.val());

                if (value >= 1) {
                    value = value - 1;
                } else {
                    value = 1;
                }
                if (value < 1) {
                    $(this).parents("tr").remove();
                }

                $input.val(value);
                $total.html(value * data.harga);
                calcTotal();
            });

            $(".total").html($(".jumlah").val() * data.harga);
            $("#total_bayar").html("Rp. " + parseInt($(".total").html()));
            $(".btn-plus").on("click", function(e) {
                e.preventDefault();
                var $parent = $(this).closest("tr");
                var $input = $parent.find(".jumlah");
                var $total = $parent.find(".total");
                var value = parseInt($input.val());

                if (value < 100) {
                    value = value + 1;
                } else {
                    value = 100;
                }

                $input.val(value);
                $total.html(value * data.harga);
                calcTotal();
            });

            const t = new Date();
            const date = ("0" + t.getDate()).slice(-2);
            const month = ("0" + (t.getMonth() + 1)).slice(-2);
            const year = t.getFullYear();
            let today = year + "-" + month + "-" + date;
            $(".datepicker").val(today);
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

function calcTotal() {
    let total = 0;
    $(".total").each(function() {
        total += parseInt($(this).html());
    });
    $("#total_bayar").html("Rp. " + total);
}

//reload datatable ajax
function reload_table_trns() {
    $("#datatable").DataTable().ajax.reload();
}

// add
function add_transaksi() {
    $(".text-danger").empty(); // clear error string
    $("#transaksi_modal").modal("show"); // show bootstrap modal
    $(".modal-title").text("Transaksi Baru"); // Set Title to Bootstrap modal title
    $(".add-data").val(""); // reset form on modals
    $('[name="id_transaksi"]').val("");
    $("#transaksi_form")[0].reset(); // reset form on modals

    $("#pilih-barang").prop(
        "style",
        "display:none", // button delete all hide
        true
    );
    // show barang
    $("#id_pembeli").change(function(e) {
        e.preventDefault();
        $("#pilih-barang").removeAttr("style");
    });
}

// save
function save_transaksi() {
    // console.log($("#transaksi_form").serialize());
    $("#btnSave").html("Diproses...");
    $("#btnSave").attr("disabled", true); //set button disable
    // ajax adding data to database
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
        url: "transaksi/save",
        type: "POST",
        dataType: "JSON",
        data: $("#transaksi_form").serializeArray(),
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
            reload_table_trns();
            // $("#btnSave").text("Simpan"); //change button text
            $("#btnSave").html("Bayar sekarang");
            $("#btnSave").attr("disabled", false); //set button enable
        },
        error: function(response) {
            console.log(response);
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
            $("#btnSave").html("Bayar sekrang");
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
                    reload_table_trns();
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