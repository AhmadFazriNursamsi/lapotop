<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListProductKarantina extends Model
{
    use HasFactory;
    protected $table = "list_product_karantina";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    public $timestamps = false;

    
}
