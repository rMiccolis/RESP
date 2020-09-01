<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Sep 2018 06:05:03 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

class StatiIndagine extends Eloquent
{
    protected $table = 'StatiIndagine';
    protected $primaryKey = 'Code';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
    'Display'
    ];
}