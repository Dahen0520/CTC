<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_visita_id',
        'precio',
        'fecha',
        'numero_identidad',
    ];

    public function tipoVisita()
    {
        return $this->belongsTo(TipoVisita::class);
    }
}
