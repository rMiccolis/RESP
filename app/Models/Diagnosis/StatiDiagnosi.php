<?php
/**
 * Created by IntelliJ IDEA.
 * User: Gaetano
 * Date: 18/06/2019
 * Time: 17:20
 */

namespace App\Models\Diagnosis;

use Reliese\Database\Eloquent\Model as Eloquent;

class StatiDiagnosi extends Eloquent
{
    protected $table = 'StatiDiagnosi';
    protected $primaryKey = 'Code';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Display'
    ];
}