<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class list_product extends Model
{
    use HasFactory;
    protected $table = "list_product";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    public $timestamps = false;

    public function productss()
    {
        return $this->hasMany('App\Models\Product','id', 'id_product');
    }
}
