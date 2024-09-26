<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'mes', 'ano', 'minutos_usados', 'minutos_excedentes', 'custo_excedente', 'total_custo', 'fechado',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
