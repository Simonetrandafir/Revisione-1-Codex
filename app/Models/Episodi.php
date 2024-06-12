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

    protected $with=['serieTv','files'];

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

    ];

    public function serieTv()
    {
        return $this->belongsTo(SerieTv::class, 'idSerieTv');
    }
    public function files()
    {
        return $this->morphMany(Files::class, 'record');
    }
}

