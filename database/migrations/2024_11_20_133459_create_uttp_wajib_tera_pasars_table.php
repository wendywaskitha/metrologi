<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('uttp_wajib_tera_pasars', function (Blueprint $table) {
            $table->id();
            $table->double('kap_max')->nullable();
            $table->double('daya_baca')->nullable();
            $table->string('merk')->nullable();
            $table->date('tgl_uji')->nullable();
            $table->date('expired')->nullable();
            $table->string('status')->nullable();
            $table->string('file')->nullable();
            $table->foreignId('wajib_tera_pasar_id');
            $table->foreignId('jenis_uttp_id');
            $table->foreignId('satuan_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uttp_wajib_tera_pasars');
    }
};
