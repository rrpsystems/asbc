<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

   // Defina os atributos que podem ser preenchidos em massa
   protected $fillable = ['prefixo','carrier_id','tarifa','descricao','tempoinicial','tempominimo',
    'incremento','compra','venda','vconexao','ativo',
];

// Defina os atributos que devem ser convertidos para tipos específicos
protected $casts = [
    'tempoinicial' => 'integer',
    'tempominimo' => 'integer',
    'incremento' => 'integer',
    'compra' => 'decimal:3',
    'venda' => 'decimal:3',
    'vconexao' => 'decimal:3',
    'ativo' => 'boolean',
];

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }
}
