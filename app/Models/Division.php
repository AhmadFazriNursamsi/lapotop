<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $table = "division";
    protected $primaryKey = "id_division";
    protected $fillable = ['division_name', 'active'];
    public $timestamps = false;

    public function roles()
    {
        return $this->belongsTo('App\Models\Role','id_role', 'id_role');
    }
    public function uaccess()
    {
        return $this->hasMany('App\Models\Useraccess','id_users', 'id');
    }
}
