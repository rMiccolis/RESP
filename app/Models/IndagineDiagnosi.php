<?php

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;


/**
 * Class Diagnosi
 *
 * @property int id_indagine
 * @property int id_diagnosi
 *
 * @package App\Models
 */

class IndagineDiagnosi extends Eloquent
{
    protected $table = 'indagine_diagnosi';
    public $timestamps = false;

    protected $casts = [
        'id_indagine' => 'int',
        'id_diagnosi' => 'int',
    ];


    protected $fillable = [
        'id_indagine',
        'id_diagnosi',
    ];
}
