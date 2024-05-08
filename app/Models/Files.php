<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;

    protected $table='files';

    protected $primaryKey='idFile';

    protected $fillable = [
        'idRecord',
        'tabella',
        'nome',
        'size',
        'posizione',
        'ext',
        'descrizione',
        'formato',

    ];

    public function filmFile(){
        return $this->belongsTo(Film::class,'idFile','idRecord');
    }
    public function filmVideo(){
        return $this->belongsTo(Film::class,'idVideo','idRecord');
    }
    public function serieFile(){
        return $this->belongsTo(SerieTv::class,'idFile','idRecord');
    }
    public function serieVideo(){
        return $this->belongsTo(SerieTv::class,'idVideo','idRecord');
    }
    public function episodiFile(){
        return $this->belongsTo(Episodi::class,'idFile','idRecord');
    }
    public function episodiVideo(){
        return $this->belongsTo(Episodi::class,'idVideo','idRecord');
    }
}
