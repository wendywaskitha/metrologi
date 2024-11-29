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
        Schema::create('uttp_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wajib_tera_pasar_id')->constrained('wajib_tera_pasars');
            $table->foreignId('jenis_uttp_id')->constrained('jenis_uttps');
            $table->foreignId('uttp_wajib_tera_pasar_id')->constrained('uttp_wajib_tera_pasars');
            $table->date('tgl_uji')->nullable();
            $table->date('expired')->nullable();
            $table->string('status')->nullable();
            $table->string('merk')->nullable();
            $table->double('kap_max')->nullable();
            $table->foreignId('satuan_id')->nullable()->constrained('satuans');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wajib_tera_pasar_jenis_uttp_history');
    }
};
