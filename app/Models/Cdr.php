<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cdr extends Model
{
    use HasFactory;

    protected $fillable = [
        'uniqueid', 'clid', 'src', 'dst', 'dcontext', 'channel', 'dstchannel', 'lastapp', 'lastdata',
        'start', 'answer', 'end', 'duration', 'billsec', 'disposition', 'amaflags', 'accountcode',
        'userfield', 'recordingfile',
    ];
}
