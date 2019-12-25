<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pangkalan extends Model
{
    //
    protected $table = 'trn_pangkalans';
    protected $primaryKey = 'pangkalan_id';

    protected $fillable = [
        'region_id',
        'regiondetil_id',
        'pangkalan_name',
        'group_id',
        'pangkalan_address',
        'pangkalan_email',
        'pangkalan_phone',
        'pangkalan_instrukturname',
        'pangkalan_gudep',
        'pangkalan_disable'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class,'region_id');
    }

    public function regiondetil()
    {
        return $this->belongsTo(ReginDetail::class,'regiondetil_id');
    }
}
