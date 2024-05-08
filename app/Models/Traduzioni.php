<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Traduzioni extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="traduzioni";
    protected $primaryKey="idTraduzione";
    protected $fillable = [
        'idLingua',
        'chiave',
        'valore',
    ];

    
    public function lingue(){
        return $this->hasMany(Lingue::class,'idLingua', 'idLingua');
    }
}
