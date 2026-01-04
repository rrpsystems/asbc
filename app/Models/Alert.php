<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'severity',
        'customer_id',
        'carrier_id',
        'title',
        'message',
        'metadata',
        'read_at',
        'resolved_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'read_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    // Tipos de alerta
    const TYPE_FRANCHISE_EXCEEDED = 'franchise_exceeded';
    const TYPE_FRANCHISE_WARNING = 'franchise_warning'; // 80% da franquia
    const TYPE_TARIFACAO_ERROR = 'tarifacao_error';
    const TYPE_PEAK_CHANNELS = 'peak_channels';
    const TYPE_FRAUD_DETECTED = 'fraud_detected';
    const TYPE_HIGH_COST = 'high_cost';
    const TYPE_CARRIER_FAILURE = 'carrier_failure';

    // Severidades
    const SEVERITY_LOW = 'low';
    const SEVERITY_MEDIUM = 'medium';
    const SEVERITY_HIGH = 'high';
    const SEVERITY_CRITICAL = 'critical';

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeUnresolved($query)
    {
        return $query->whereNull('resolved_at');
    }

    public function scopeBySeverity($query, $severity)
    {
        return $query->where('severity', $severity);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    public function markAsResolved()
    {
        $this->update(['resolved_at' => now()]);
    }

    public function isRead()
    {
        return !is_null($this->read_at);
    }

    public function isResolved()
    {
        return !is_null($this->resolved_at);
    }
}
