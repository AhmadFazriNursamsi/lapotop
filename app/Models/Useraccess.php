<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Useraccess extends Model
{
    use HasFactory;
    protected $table = "user_access";
    public $timestamps = false;
    protected $primaryKey = 'id_access';
    
}
