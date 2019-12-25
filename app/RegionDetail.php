<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegionDetail extends Model
{
    protected $table = 'mst_regiondetil';
    protected $primaryKey = 'regiondetil_id';
    protected $fillable = [
        'region_id',
        'regiondetil_name',
        'regiondetil_description',
        'regiondetil_disable'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class,'region_id');
    }

    public function pangkalan()
    {
        return $this->hasMany(Pangkalan::class,'regiondetil_id');
    }
}
