<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SemuaTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('pembeli', function (Blueprint $table) {
            $table->increments('id_pembeli');
            $table->string('nama_pembeli', 250);
            // $table->char('jk', 30);
            $table->enum('jk', ['L', 'P']);
            $table->char('no_telp', 20);
            $table->string('alamat', 250);
            $table->timestamps();
        });

        Schema::create('supplier', function (Blueprint $table) {
            $table->increments('id_supplier');
            $table->string('nama_supplier', 250);
            $table->char('no_telp', 20);
            $table->string('alamat', 250);
            $table->timestamps();
        });

        Schema::create('barang', function (Blueprint $table) {
            $table->increments('id_barang');
            $table->string('nama_barang', 250);
            $table->integer('harga');
            $table->integer('stok');

            $table->unsignedInteger('id_supplier')->nullable();
            $table->timestamps();

            $table->foreign('id_supplier')->references('id_supplier')->on('supplier');
        });

        Schema::create('transaksi', function (Blueprint $table) {
            $table->increments('id_transaksi');
            $table->unsignedInteger('id_barang')->nullable();
            $table->unsignedInteger('id_pembeli')->nullable();
            $table->integer('jumlah');
            $table->date('tanggal');
            $table->string('keterangan', 250);
            $table->timestamps();

            $table->foreign('id_barang')->references('id_barang')->on('barang');
            $table->foreign('id_pembeli')->references('id_pembeli')->on('pembeli');
        });

        Schema::create('pembayaran', function (Blueprint $table) {
            $table->increments('id_pembayaran');
            $table->date('tgl_bayar');
            $table->integer('total_bayar');
            $table->unsignedInteger('id_transaksi')->nullable();
            $table->timestamps();

            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}