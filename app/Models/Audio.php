<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    use HasFactory;

    protected $table = 'audio';

    protected $fillable = [
        'name',
        'description',
        'filename',
        'mime_type',
        'content',
        'path',
        'file_size',
    ];

    protected $hidden = [
        'content',
    ];
}
