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
        'record_id',
        'record_tipo',
        'tipo',
        'nome',
        'size',
        'posizione',
        'ext',
        'descrizione',
        'formato',

    ];
    public function filable()
    {
        return $this->morphTo();
    }
}
