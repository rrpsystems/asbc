<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'operadora', 'canais', 'data_inicio', 'ativo'];

    protected $casts = [
        'ativo' => 'boolean',
        ];
}
