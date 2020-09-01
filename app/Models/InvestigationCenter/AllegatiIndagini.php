<?php


namespace App\Models\InvestigationCenter;


use Reliese\Database\Eloquent\Model as Eloquent;

class AllegatiIndagini extends Eloquent
{
    protected $table = 'tbl_allegati_indagini';
    protected $primaryKey = ['id_indagine','id_file'];
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'id_indagine' => 'int',
        'id_file' => 'int'
    ];

    protected $fillable = ['id_indagine', 'id_file'];
}