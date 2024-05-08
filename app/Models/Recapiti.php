<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recapiti extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='recapiti';

    protected $primaryKey = "idRecapito";

    protected $fillable=[
        'idContatto',
        'idTipoRecapito',
        'recapito'
    ];


    public function recapitiContatti(){
        return $this->hasMany(Contatti::class,'idContatto', 'idContatto');
    }
    public function tipoRecapiti(){
        return $this->hasMany(TipoRecapiti::class,'idTipoRecapito', 'idTipoRecapito');
    }
}
