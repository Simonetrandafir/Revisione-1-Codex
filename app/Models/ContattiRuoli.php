<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContattiRuoli extends Model
{
    use HasFactory;

    protected $table="contatti_ruoli";
    protected $primaryKey="id";

    protected $fillable=[
        'id',
        'idContatto',
        'idRuolo',
    ];

    public function ruoliContatti(){
        return $this->belongsToMany(Contatti::class,'idContatto', 'idContatto')->orderBy('idContatto','ASC');
    }
    public function ruoli(){
        return $this->belongsToMany(Ruoli::class,'idRuolo', 'idRuolo')->orderBy('idRuolo','ASC');
    }
}
