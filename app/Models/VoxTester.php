<?php

namespace App\Models;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;

class VoxTester extends Model
{
    use Encryptable;

    public $timestamps = false;
    protected $encryptable = [
        'date',
        'audio'
    ];

    protected $fillable = [
        'date',
        'audio'
    ];
}
