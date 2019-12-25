<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    //
    protected $table = 'mst_unit'; //untuk mendeklarasikan ulang nama table dari mysql
    protected $primaryKey = 'unit_id';
    public $incrementing = false;
    protected $fillable = [
        'unit_code',
        'unit_name',
        'unit_description',
        'unit_disable'
    ];
}
