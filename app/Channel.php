<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $table = 'mst_channel'; //untuk mendeklarasikan ulang nama table dari mysql
    protected $primaryKey = 'channel_id';
    public $incrementing = false;
    protected $fillable = [
        'channel_id',
        'channel_name',
        'channel_description',
        'channel_date',
        'channel_createby',
        'channel_createdt',
        'channel_modifiedby',
        'channel_modifieddt',
        'channel_disable',
        'channel_disabledt'
    ];
}
