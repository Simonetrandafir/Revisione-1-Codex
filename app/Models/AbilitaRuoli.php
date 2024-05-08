<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbilitaRuoli extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'abilita_ruoli';
    protected $primaryKey = "id";

    protected $fillable=[
        'id',
        'idAbilita',
        'idRuolo',
    ];

    // public function connectAbilita(){
    //     return $this->hasMany(Abilita::class,'idAbilita', 'idAbilita')->orderBy('idAbilita','ASC');
    // }
    public function ruoli(){
        return $this->belongsToMany(Ruoli::class,'idRuolo', 'idRuolo');
    }
    public function abilita(){
        return $this->belongsToMany(Abilita::class,'idAbilita', 'idAbilita');
    }
}
