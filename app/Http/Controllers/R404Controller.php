<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class R404Controller extends Controller
{

	public function r404(){
    	return response()->json(['data' => [], 'status' => '404'], 404);
    }

    public function r405(){
    	return response()->json(['data' => [], 'status' => '405'], 405);
    }

    public function r500(){
    	return response()->json(['data' => [], 'status' => '500'], 500);
    }
}
