<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         $query="
        CREATE VIEW vista_traduzioni AS
        SELECT idTraduzione AS id, idLingua, chiave, valore, 'standard' AS tipo
        FROM traduzioni
        UNION ALL
        SELECT idTraduzioneC AS id, idLingua, chiave, valore, 'custom' AS tipo
        FROM traduzioni_customs
    ";
        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS vista_traduzioni");
    }
};
