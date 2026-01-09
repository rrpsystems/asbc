<?php

namespace App\Models;

use App\Enums\DialStatus;
use App\Enums\IsdnHangupCause;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cdr extends Model
{
    use HasFactory;

    protected $fillable = [
        'uniqueid', 'clid', 'src', 'dst', 'dcontext', 'channel', 'dstchannel', 'lastapp', 'lastdata',
        'start', 'answer', 'end', 'duration', 'billsec', 'disposition', 'amaflags', 'accountcode',
        'userfield', 'recordingfile', 'cobrada', 'revenue_summary_id',
        'valor_venda_final', 'valor_markup',
        // Novos campos SIP e Q.850
        'sip_code', 'sip_reason', 'q850_cause', 'q850_description', 'reason_header', 'failure_type',
    ];

    public function getHangupAttribute($value)
    {
        return IsdnHangupCause::tryFrom($value)?->getCauseDescription() ?? 'Desconhecido';
    }

    public function getDispositionAttribute($value)
    {
        return DialStatus::tryFrom($value)?->getDisposition() ?? 'Desconhecido';
    }

    /**
     * Retorna o número bruto (sem formatação)
     * Use o helper PhoneHelper::format() na view para formatar
     */
    public function getNumeroRawAttribute()
    {
        return $this->attributes['numero'] ?? '';
    }

    /**
     * Retorna o DID bruto (sem formatação)
     * Use o helper PhoneHelper::format() na view para formatar
     */
    public function getDidIdRawAttribute()
    {
        return $this->attributes['did_id'] ?? '';
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }

    public function revenueSummary()
    {
        return $this->belongsTo(RevenueSummary::class);
    }
}
