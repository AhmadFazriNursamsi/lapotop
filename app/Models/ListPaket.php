<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListPaket extends Model
{
    use HasFactory;
    protected $table = "list_paket_produk";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    public $timestamps = false;

    public function detailPaket()
    {
        return $this->hasMany('App\Models\DetailPaket','id_list_paket', 'id');
    }

    
}
