<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
    	$pagetest = 'test';
    	return view('dashboard.index', array(
            'pagetest'  => $pagetest,
        ));
    }
}
