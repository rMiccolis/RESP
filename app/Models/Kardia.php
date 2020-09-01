<?php

namespace App\Models;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;

class Kardia extends Model
{
    use Encryptable;

    public $timestamps = false;

    protected $encryptable = [
        'date',
        'filepdf'
    ];

    protected $fillable = [
        'date',
        'filepdf'
    ];
}
