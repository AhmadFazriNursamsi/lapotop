<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loc_village extends Model
{
    use HasFactory;
    protected $table = "loc_village";
    public $timestamps = false;

    public function alamat()
    {
        return $this->belongsTo('App\Models\Alamat','id', 'id');
    }
    public function district()
    {
        return $this->hasMany('App\Models\Loc_district','id', 'id');
    }
    public function city()
    {
        return $this->belongsTo('App\Models\Loc_city','id', 'id');
    }
    public function province()
    {
        return $this->hasMany('App\Models\Loc_province','id', 'id');
    }
    public function customer()
    {
        return $this->hasMany('App\Models\Customer','id', 'id_customer');
    }
}
