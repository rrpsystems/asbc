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
        'userfield', 'recordingfile', 'cobrada',
    ];

    public function getHangupAttribute($value)
    {
        return IsdnHangupCause::tryFrom($value)?->getCauseDescription() ?? 'Desconhecido';
    }

    public function getDispositionAttribute($value)
    {
        return DialStatus::tryFrom($value)?->getDisposition() ?? 'Desconhecido';
    }

    public function getNumeroAttribute($value)
    {
        return $this->formatPhone($value);
    }

    public function getDidIdAttribute($value)
    {
        return $this->formatPhone($value);
    }

    protected function formatPhone($str)
    {

        if (substr($str, 0, 2) === '00') {
            return substr($str, 0, 2).' ('.substr($str, 2, 2).') '.substr($str, 4, 3).'-'.substr($str, 7);
        } elseif (substr($str, 0, 4) === '0800' || substr($str, 0, 4) === '0300') {
            return substr($str, 0, 4).'-'.substr($str, 4, 3).'-'.substr($str, 7);
        } elseif (strlen($str) === 10) {
            return '('.substr($str, 0, 2).') '.substr($str, 2, 4).'-'.substr($str, 6);
        } elseif (strlen($str) === 11) {
            return '('.substr($str, 0, 2).') '.substr($str, 2, 5).'-'.substr($str, 7);
        } else {
            return $str;
        }

    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }
}
