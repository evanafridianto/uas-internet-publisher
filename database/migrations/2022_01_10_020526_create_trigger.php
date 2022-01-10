<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER stok_update AFTER INSERT ON `transaksi` FOR EACH ROW
            BEGIN
                UPDATE barang SET stok = stok - NEW.jumlah WHERE id_barang = new.id_barang;
            END
        ');
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `stok_update`');
    }
}