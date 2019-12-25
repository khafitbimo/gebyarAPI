<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    protected $table = 'mst_group'; //untuk mendeklarasikan ulang nama table dari mysql
    protected $primaryKey = 'group_id';
    public $incrementing = false;
    protected $fillable = [
        'group_id',
        'group_name',
        'group_description',
        'group_disable'
    ];
}
