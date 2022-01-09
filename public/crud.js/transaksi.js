var table;
var table_penj;

$(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    table_penj = $("#datatable_penjualan").DataTable({
        processing: true,
        serverSide: true,
        ajax: "/pembayaran",
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
            },
            {
                data: "kode_transaksi",
                name: "kode_transaksi",
            },
            {
                data: "transaksi.tanggal",
                name: "transaksi.tanggal",
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

    table = $("#datatable").DataTable({
        processing: true,
        serverSide: true,
        ajax: "",
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
            },
            {
                data: "kode_transaksi",
                name: "kode_transaksi",
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
                '" type="hidden"><input name="multi[' +
                i +
                '][kode_transaksi]" class="kode_transaksi" value="" type="hidden"><input type="hidden" name="multi[' +
                i +
                '][tanggal]" class="datepicker form-control"><input type="hidden" name="multi[' +
                i +
                '][id_pembeli]" value="' +
                $("#id_pembeli").find(":selected").val() +
                '" class="form-control"></td><td>' +
                data.stok +
                '</td><td><input name="multi[' +
                i +
                '][jumlah]" class="form-control jumlah text-center" type="number" value="1" min="1"></td><td class="harga">' +
                data.harga +
                '</td><td class="total">' +
                data.harga * 1 +
                '</td><td><input class="form-control" name="multi[' +
                i +
                '][keterangan]"></td><td><button type="button" class="btn btn-danger btn-xs remove-tr">Hapus</button></td></tr>'
            );

            $(document).on("click", ".remove-tr", function() {
                $(this).parents("tr").remove();
                $('[name="daftar_barang"]').prop("selectedIndex", 0);
            });

            $(".jumlah").bind("keyup change click", function(e) {
                var sum = 0;
                $(".jumlah").each(function() {
                    if ($(this).val() !== "") {
                        sum = parseInt($(this).val());
                    }
                });
                var $parent = $(this).closest("tr");
                var $total = $parent.find(".total");
                var $harga = $parent.find(".harga");
                // console.log($harga.html());
                $total.html(sum * parseInt($harga.html()));

                // console.log(parseInt($harga.html()));

                let total = 0;
                $(".total").each(function() {
                    total += parseInt($(this).html());
                });
                $("#total_bayar").html("Rp. " + total);
            });

            const t = new Date();
            const date = ("0" + t.getDate()).slice(-2);
            const month = ("0" + (t.getMonth() + 1)).slice(-2);
            const year = t.getFullYear();
            let today = year + "-" + month + "-" + date;
            $(".datepicker").val(today);

            var dt = new Date();
            var time =
                dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
            $(".kode_transaksi").val("TRANS-" + time);

            let totalharga = 0;
            $(".total").each(function() {
                totalharga += parseInt($(this).html());
            });
            $("#total_bayar").html("Rp. " + totalharga);
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
function reload_table_trns() {
    $("#datatable").DataTable().ajax.reload();
}

function reload_tablePen() {
    $("#datatable_penjualan").DataTable().ajax.reload();
}
// add
function add_transaksi(e) {
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
    let kode_trns = $(".kode_transaksi").val();

    $("#btnSave").html("Diproses...");
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
        dataType: "JSON",
        data: $("#transaksi_form").serializeArray(),
        success: function(data) {
            $("#transaksi_modal").modal("hide");
            swal({
                title: "Sukses!",
                // text: "Transaksi berhasil!",
                // html: '<a target="_BLANK" href="transaksi/cetak/" type="button" class="btn btn-info  btn-sm" >Cetak</a>',
                html: "Transaksi : " +
                    kode_trns +
                    " berhasil!" +
                    "<br>" +
                    '<button type="button" class="btn btn-primary close">x</button>' +
                    "  " +
                    '<a type="button" href="transaksi/cetak/' +
                    kode_trns +
                    '" target="_BLANK" class="btn btn-info cetak">Cetak</a>',
                type: "success",
                showConfirmButton: false,
                // timer: 1500,
            }).then(
                function() {},
                // handling the promise rejection
                function(dismiss) {
                    if (dismiss === "timer") {}
                }
            );
            $(".close").click(function(e) {
                e.preventDefault();
                swal.clickConfirm();
            });
            // $.ajax({
            //     url: "transaksi/update_stok",
            //     type: "POST",
            //     dataType: "JSON",
            //     data: $("#transaksi_form").serializeArray(),
            //     success: function(response) {},
            // });

            // save pembayaran
            let total = 0;
            $(".total").each(function() {
                total += parseInt($(this).html());
            });

            let kode = $(".kode_transaksi").val();
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                url: "pembayaran/save",
                type: "POST",
                data: {
                    _token: CSRF_TOKEN,
                    total_bayar: total,
                    kode_transaksi: kode,
                },
                dataType: "JSON",
                success: function(bayar) {},
                error: function(data_error) {
                    console.log(data_error.responseJSON.message);
                },
            });
            //if success reload ajax table
            reload_table_trns();
            reload_tablePen();
            // $("#btnSave").text("Simpan"); //change button text
            $("#btnSave").html("Bayar sekarang");
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
            $("#btnSave").html("Bayar sekarang");
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

// delete pembayaran
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
                    reload_tablePen();
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