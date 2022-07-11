<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPaket extends Model
{
    use HasFactory;
    protected $table = "detail_paket_produk";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany('App\Models\Product','id', 'id_product');
    }
    public function list_paket()
    {
        return $this->hasMany('App\Models\ListPaket','id', 'id');
    }

}
