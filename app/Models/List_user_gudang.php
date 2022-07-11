<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class List_user_gudang extends Model
{
    use HasFactory;

    protected $table = "list_user_gudang";
    protected $primaryKey = "id";
    protected $guarded = ['id'];
    public $timestamps = false;

    public function gudang()
    {
        return $this->hasMany('App\Models\Gudang','id', 'id');
    }
    public function users()
    {
        return $this->hasMany('App\Models\User','id', 'id_user');
    }
}
