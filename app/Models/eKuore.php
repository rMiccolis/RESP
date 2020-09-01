<?php

namespace App\Models;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;

class eKuore extends Model
{
    use Encryptable;

    public $timestamps = false;
    protected $encryptable = [
        'date',
        'fileaudio'
    ];

    protected $fillable = [
        'date',
        'fileaudio'
    ];
}
