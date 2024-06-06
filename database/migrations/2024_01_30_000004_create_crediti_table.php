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
        Schema::create('crediti', function (Blueprint $table) {
            $table->id('idCredito');
            $table->unsignedBigInteger('idContatto')->index();
            $table->unsignedInteger('credito')->default(100);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('idContatto')->references('idContatto')->on('contatti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crediti');
    }
};
