<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Did extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'carrier_id',
        'did',
        'encaminhamento',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function calls()
    {
        return $this->hasMany(Cdr::class);
    }
}
