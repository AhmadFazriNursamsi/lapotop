<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loc_district extends Model
{
    use HasFactory;
    protected $table = "loc_district";
    public $timestamps = false;


    public function alamat()
    {
        return $this->belongsTo('App\Models\Alamat','id', 'id');
    }
    public function city()
    {
        return $this->hasMany('App\Models\Loc_city','id', 'city_id');
    }
    public function province()
    {
        return $this->hasMany('App\Models\Loc_province','id', 'id');
    }
    public function village()
    {
        return $this->hasMany('App\Models\Loc_village','id', 'id');
    }
    public function customer()
    {
        return $this->hasMany('App\Models\Customer','id', 'id_customer');
    }
}
