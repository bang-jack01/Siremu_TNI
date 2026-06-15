<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrajuritTable extends Migration
{
    public function up()
    {
        Schema::create('prajurit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // HILANGKAN ->after('id')
            $table->string('name', 100);
            $table->string('nrp', 16);
            $table->string('korp', 3);
            $table->string('satuan_asal', 100);
            $table->string('satuan_baru', 100);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->string('no_kep', 50)->nullable();
            $table->date('tgl_kep')->nullable();
            $table->string('no_sprin', 50)->nullable();
            $table->date('tgl_sprin')->nullable();
            $table->string('nik', 50);
            $table->string('alamat', 255);
            $table->string('pangkat', 50);
            $table->string('angkatan', 255)->nullable(); // HILANGKAN ->after('pangkat')
            $table->string('no_hp', 20);
            $table->string('foto', 255)->nullable();
            $table->timestamps();
        });
    }
    


    public function down()
    {
        Schema::table('prajurit', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
        $table->dropColumn('angkatan');
    });
    }
}
