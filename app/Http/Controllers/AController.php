<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;

class AController extends Controller
{
    public $access = false;

    public function __construct(Request $request){
        // $explodeMethode = explode('Controller@', str_replace('App\Http\Controllers\\', '', Route::getCurrentRoute()->getActionName()));
        // $controler_name = strtolower($explodeMethode[0]);
        // $methode_name = strtolower($explodeMethode[1]);
        // // ini_set('display_errors', 1);
        // // ini_set('display_startup_errors', 1);
        // // error_reporting(E_ALL);
    }
}
