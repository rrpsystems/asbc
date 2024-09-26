<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;

    protected $fillable = [
        'did_id', 'data_hora_inicio', 'data_hora_fim', 'duracao_segundos', 'tipo_chamada', 'custo',
    ];

    public function did()
    {
        return $this->belongsTo(Did::class);
    }
}
