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
        Schema::create('files', function (Blueprint $table) {
            $table->id('idFile');
            $table->unsignedBigInteger('idRecord')->nullable();
            $table->string('tabella',45)->nullable();
            $table->string('nome',255);
            $table->unsignedBigInteger('size');
            $table->string('posizione',255);
            $table->string('ext',6);
            $table->string('descrizione',45)->nullable();
            $table->string('formato',45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
