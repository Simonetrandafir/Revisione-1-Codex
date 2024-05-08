<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ComuniItaliani extends Model
{
    use HasFactory;
    protected $table="comuni_italiani";
    protected $primaryKey="idComuneItalia";
    
    protected $fillable = [
        'idComuneItalia',
        'nome',
        'regione',
        'metropolitana',
        'provincia',
        'siglaAuto',
        'codCatastale',
        'capoluogo',
        'multiCap',
        'cap',
        'capInizio',
        'capFine',
    ];

    public static function trovaComune($idComune){
        $tmp=intval($idComune);
        return DB::table('comuni_italiani')->where('idComuneItalia',$tmp)->first();
    }
}
