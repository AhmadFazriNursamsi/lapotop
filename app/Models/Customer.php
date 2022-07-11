<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    // protected $fillable = ['name', 'email', 'no_tlp', 'active'];
    protected $guarded = ['id'];


    public function alamats()
    {
        return $this->hasMany('App\Models\Alamat','id_customer', 'id');
    }
    public function province()
    {
        return $this->hasMany('App\Models\Loc_province','id', 'province');
    }
    public function city()
    {
        return $this->belongsTo('App\Models\Loc_city','id', 'id');
    }
    public function district()
    {
        return $this->hasMany('App\Models\Loc_district','id', 'id');
    }
    public function village()
    {
        return $this->hasMany('App\Models\Loc_village','id', 'id');
    }
    
}
