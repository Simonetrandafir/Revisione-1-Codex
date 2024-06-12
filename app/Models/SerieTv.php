<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SerieTv extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'serie_tv';
    protected $primaryKey = 'idSerieTv';

    protected $with=['categoria','genere','episodi','files'];

    protected $fillable = [
        'idSerireTv',
        'idCategoria',
        'idGenere',
        'titolo',
        'trama',
        'totStagioni',
        'nEpisodi',
        'regista',
        'attori',
        'annoInizio',
        'annoFine',
        'visualizzato',
    ];

    public function categoria(){
        return $this->hasOne(Categorie::class,'idCategoria','idCategoria');
    }
    public function genere(){
        return $this->belongsToMany(Genere::class,'idGenere', 'idGenere');
    }
    public function episodi(){
        return $this->hasMany(Episodi::class);
    }
    public function files()
    {
        return $this->morphMany(Files::class, 'record');
    }
}
