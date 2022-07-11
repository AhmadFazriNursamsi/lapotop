<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karantina extends Model
{

    use HasFactory;
    protected $table = "karantina";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    public $timestamps = false;
}
