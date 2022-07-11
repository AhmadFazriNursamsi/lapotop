<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Config;
use App\Models\Division;
use App\Models\Role;
use App\Models\Useraccess;
use App\Models\Listaccess;
use App\Http\Controllers\HelpersController as Helpers;

class ConfigController extends Controller
{
    public function index(){
        $this->access = Helpers::checkaccess('config', 'view');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }

        $datas = Config::get();
        return view('config.index', array(
            'datas'  => $datas,
        ));
    }

    public function apiInsertData(Request $request){
        $this->access = Helpers::checkaccess('listaccess', 'add');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

        $validator = Validator::make($request->all(), [
           'name_access' => 'required',
           'name_url' => 'required'
       ]);
        
       if ($validator->fails()) {
            return response()->json(['data' => [$validator->messages()->first()], 'status' => '401'], 200);
       }

        $datas = new Listaccess;
        $datas->name_access = $request->name_access;
        $datas->name_url = $request->name_url;
        if($datas->save())
            return response()->json(['data' => ['success'], 'status' => '200'], 200);
        else 
            return response()->json(['data' => ['false'], 'status' => '200'], 200);
    }


    public function apiUpdateData(Request $request){
        $this->access = Helpers::checkaccess('listaccess', 'edit');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

        $validator = Validator::make($request->all(), [
           'id_access' => 'required',
           'name_access' => 'required',
           'name_url' => 'required'
       ]);
        
       if ($validator->fails()) {
            return response()->json(['data' => [$validator->messages()->first()], 'status' => '401'], 200);
       }

        $datas = Listaccess::where('id_access', $request->id_access)->first();
        $datas->name_access = $request->name_access;
        $datas->name_url = $request->name_url;
        if($datas->save())
            return response()->json(['data' => ['success'], 'status' => '200'], 200);
        else 
            return response()->json(['data' => ['false'], 'status' => '200'], 200);
    }
}
