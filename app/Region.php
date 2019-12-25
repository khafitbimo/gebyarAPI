<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'mst_region';
    protected $primaryKey = 'region_id';
    protected $fillable = [
        'region_name',
        'region_description',
        'region_disable'
    ];

    public function regionDetail()
    {
        return $this->hasMany(RegionDetail::class,'region_id');
    }

    public function pangkalan()
    {
        return $this->hasMany(Pangkalan::class,'region_id');
    }
}
