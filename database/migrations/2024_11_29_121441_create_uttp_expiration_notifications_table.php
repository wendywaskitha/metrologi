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
        Schema::create('uttp_expiration_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uttp_id');
            $table->unsignedBigInteger('wajib_tera_pasar_id');
            $table->string('type'); // 'near_expiration' atau 'expired'
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->foreign('uttp_id')
                ->references('id')
                ->on('uttp_wajib_tera_pasars')
                ->onDelete('cascade');

            $table->foreign('wajib_tera_pasar_id')
                ->references('id')
                ->on('wajib_tera_pasars')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uttp_expiration_notifications');
    }
};
