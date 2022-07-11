<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Division;
use App\Models\Role;
use Illuminate\Support\Facades\Session;
use App\Models\Useraccess;
use App\Models\Listaccess;
use App\Http\Controllers\HelpersController as Helpers;
use Auth;
use Illuminate\Support\Facades\Validator;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class servieController extends Controller
{

	public function apiDetail($id, Request $request){

        $datas  = Division::where('id_division', $id)->first();
      
        return response()->json(['data' => $datas, 'status' => '200'], 200);

	
    }
	
	public function apiDestroy($id, Request $request)
    {
		$this->access = Helpers::checkaccess('users', 'delete');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

		$datas = Division::where('id_division',$id)->first();
        $datas->flag_delete = 1;

        if(isset($request->undeleted)) $datas->flag_delete = 0;
        $datas->save();
    
        return response()->json(['data' => $datas, 'status' => '200'], 200);;
    }
}
