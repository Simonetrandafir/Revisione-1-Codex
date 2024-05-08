<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Episodi extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'episodi';
    protected $primaryKey = 'idEpisodio';

    protected $with=['files','videos'];

    protected $fillable = [
        'idEpisodio',
        'idSerieTv',
        'titolo',
        'trama',
        'stagione',
        'episodio',
        'durata',
        'anno',
        'visualizzato',
        'idFile',
        'idVideo',
    ];

    public function files(){
        return $this->hasMany(Files::class,'idFile', 'idFile');
    }
    public function videos(){
        return $this->hasMany(Files::class,'idFile', 'idVideo');
    }
}
