<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Division;
use App\Models\Role;
use App\Models\Useraccess;
use App\Models\Listaccess;
use App\Http\Controllers\HelpersController as Helpers;

class ApisController extends AController
{
    public function apigetdatauser(Request $request){
    	$this->access = Helpers::checkaccess('users', 'view');
        if(!$this->access) return response()->json(['data' => $datas, 'status' => '401'], 200);


    	$users = User::with('divisions', 'roles');
    	if($request->name != null || $request->email != null || $request->division != null || $request->username != null || $request->role != null || $request->mobile != null || $request->active != null) {
    		$whereraw = '';

    		if($request->name != null) $whereraw .= " and name like '%$request->name%'";
    		if($request->username != null) $whereraw .= " and username like '%$request->username%'";
    		if($request->email != null) $whereraw .= " and email like '%$request->email%'";
    		if($request->mobile != null) $whereraw .= " and mobile like '%$request->mobile%'";
    		if($request->role != null) $whereraw .= " and id_role = $request->role";
    		if($request->active != null) $whereraw .= " and active = $request->active";
    		if($request->division != null) $whereraw .= " and id_division = $request->division";

    		$whereraw = preg_replace('/ and/', '', $whereraw, 1); // replace first and
    		$users = $users->whereRaw($whereraw)->where('id_role', '!=', 99)
    		->get();    	

    	} else {
    		$users = $users->where('id_role', '!=', 99)->get();
    	}

    	$datas = [];
    	foreach($users as $key => $user){
    		$datas[$key] = [
    			'', $user->name, $user->username, $user->email, $user->divisions->division_name, $user->roles->role_name, $user->mobile, $user->active, $user->id, $user->flag_delete
    		];
    	}

    	return response()->json(['data' => $datas, 'status' => '200'], 200);
    }


    public function apigetdatauserbyid($id, Request $request){
        $this->access = Helpers::checkaccess('users', 'view');
        if(!$this->access) return response()->json(['data' => $datas, 'status' => '401'], 200);

        $datas = User::with('uaccess', 'divisions', 'roles')->where('id', $id)->get();

        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    public function apigetdivisi(Request $request){
    	$this->access = Helpers::checkaccess('divisi', 'view');
        if(!$this->access) return response()->json(['data' => [], 'status' => '401'], 200);

    	$datas = Division::get();
    	return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    public function apigetUser(Request $request){
    	$this->access = Helpers::checkaccess('divisi', 'view');
        if(!$this->access) return response()->json(['data' => [], 'status' => '401'], 200);

    	$datas = User::get();
    	return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    public function apigetrole(Request $request){
    	$this->access = Helpers::checkaccess('role', 'view');
        if(!$this->access) return response()->json(['data' => [], 'status' => '401'], 200);

    	$datas = Role::where("id_role", "!=", 99)->get();
    	return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    public function apideleteuserbyid($id, Request $request){

    	$this->access = Helpers::checkaccess('users', 'delete');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

    	$datas = User::where('id', $id)->first();
    	
        $datas->flag_delete = 1;
        if(isset($request->undeleted)) $datas->flag_delete = 0;
    	
    	$datas->save();

    	echo 'success';
    }

    public function apiGetDataUserAccessById($id, Request $request){
        $this->access = Helpers::checkaccess('users_access', 'view');
        if(!$this->access) return response()->json(['data' => $datas, 'status' => '401'], 200);

        $datas = Useraccess::where('id_users', $id)->get();

        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    public function apiGetDataUserAccessById2($id){

        // dd($id);
        $this->access = Helpers::checkaccess('users_access', 'view');
        if(!$this->access) return response()->json(['data' => ['success'], 'status' => '401'], 200);

        $datas = Division::select("default_access")->where('id_division', $id)->first();
        // dd($datas);

        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }


    public function apiGetDataListAccess(Request $request){
        $this->access = Helpers::checkaccess('listaccess', 'view');
        if(!$this->access) return response()->json(['data' => $datas, 'status' => '401'], 200);
        $whereraw = '';

        $listaccess = Listaccess::get();
        if($request->name_access != null || $request->name_url != null || $request->active != null){
            if($request->name_access != null) $whereraw .= " and name_access like '%$request->name_access%'";
            if($request->name_url != null) $whereraw .= " and name_url like '%$request->name_url%'";
            if($request->active != null) $whereraw .= " and flag_delete = $request->active";

            $whereraw = preg_replace('/ and/', '', $whereraw, 1); // replace first and
            $listaccess = Listaccess::whereRaw($whereraw)->get();
        } else {
            $listaccess = Listaccess::get();
        }

        $datas = [];
        foreach($listaccess as $key => $access){
            $datas[$key] = [
                '', $access->name_access, $access->name_url, $access->flag_delete, $access->id_access
            ];
        }

        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    public function apiGetDataListAccessById($id, Request $request){
        $this->access = Helpers::checkaccess('listaccess', 'view');
        if(!$this->access) return response()->json(['data' => $datas, 'status' => '401'], 200);

        $datas = Listaccess::where('id_access', $id)->get();

        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    public function apiDeleteListAccessById($id, Request $request){
        $this->access = Helpers::checkaccess('listaccess', 'delete');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

        $datas = Listaccess::where('id_access', $id)->first();
        
        $datas->flag_delete = 1;
        if(isset($request->undeleted)) $datas->flag_delete = 0;
        
        $datas->save();

        echo 'success';
    }
}
