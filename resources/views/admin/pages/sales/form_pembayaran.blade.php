<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="pembayaran_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="pembayaran_form">
                <div class="modal-body">
                    <input type="hidden" class="form-control input-default" name="id_pembayaran">
                    <div class="form-group">
                        <label class="text-warning">Nama Pembeli</label>
                        <select class="form-control add-data" disabled="disabled" name="id_pembeli">
                            @foreach ($pembeli as $list)
                                <option value="{{ $list->id_pembeli }}">{{ $list->nama_pembeli }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger"></span>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-warning">Tanggal Pembayaran</label>
                                <input name="tgl_bayar" class="datepicker form-control" readonly
                                    placeholder="Masukkan Tanggal">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-warning">ID Transaksi</label>
                                <input type="text" class="form-control input-default" readonly name="id_transaksi"
                                    placeholder="ID Transaksi">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-warning">Nama Barang</label>
                                <select class="form-control add-data" disabled="disabled" name="id_barang">
                                    @foreach ($barang as $list)
                                        <option value="{{ $list->id_barang }}">{{ $list->nama_barang }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-warning">Harga Satuan</label>
                                <input type="text" class="form-control input-default" disabled="disabled" name="harga"
                                    placeholder="Harga">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-warning">Jumlah</label>
                                <input type="text" class="form-control input-default" disabled="disabled" name="jumlah"
                                    placeholder="Jumlah">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-warning">Total Bayar (Rp)</label>
                                <input type="text" class="form-control input-default" readonly name="total_bayar"
                                    placeholder="Total Bayar">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnKonfir"
                        onclick="save_pembayaran()">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('crud.js/pembayaran.js') }}"></script>
