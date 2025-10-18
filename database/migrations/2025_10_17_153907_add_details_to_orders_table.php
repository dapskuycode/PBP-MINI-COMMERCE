<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('nama_pemesan')->after('id');
            $table->string('kota')->after('nama_pemesan');
            $table->string('kode_pos', 10)->after('kota');
            $table->string('nomor_hp', 20)->after('kode_pos');
            $table->string('jenis_pengiriman')->after('nomor_hp');
            $table->string('metode_pembayaran')->after('jenis_pengiriman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'nama_pemesan',
                'kota',
                'kode_pos',
                'nomor_hp',
                'jenis_pengiriman',
                'metode_pembayaran'
            ]);
        });
    }

};
