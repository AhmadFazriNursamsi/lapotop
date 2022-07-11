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

class DivisionControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->access = Helpers::checkaccess('users', 'view');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }
    

        $divisions = Division::where('active', 1)->get();
        $division_access = Listaccess::where('flag_delete', 0)->get();

        return view("division.index", array(
            'datas'  => array(
                'title' => 'Division',
                'divisions' => $divisions,
                'division_access' => $division_access,
            )
        ));
    
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->access = Helpers::checkaccess('users', 'add');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }

        $divisions = Division::where('active', 1)->get();
        $roles = Role::where('active', 1)->where('id_role', '!=', 99)->get();
        $user_access = Listaccess::where('flag_delete', 0)->get();

    	return view('division.create', array(
            'datas'  => array(
                'users' => array(),
                'divisions' => $divisions,
                'roles' => $roles,
                'title' => 'Create Divisi',
                'user_access' => $user_access,
                'urls' => 'store',
            ),
            'id' => ''
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->access = Helpers::checkaccess('users', 'add');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }
        $json = json_encode($request->eCheck1);

        $validator = Validator::make($request->all(), [
            'division_name' => 'required|unique:division',
        ]);
         
        if ($validator->fails()) {
            Session::flash('message', "Divisi Sudah Terdaftar !!!");
            return redirect('/divisions/create');  
        }
        
        $id = '';

        $divi = New Division();
        $divi->division_name = $request->division_name;
        $divi->active = $request->active;
        $divi->default_access = $json;
        if($divi->save()){
            Session::flash('message', "Data has been added");
            return redirect('/divisions')->with("success", "Data Berhasil Disimpan");  
        }
        else {
            Session::flash('message', "Upps Something Wrong ... please try again !!!");
            return redirect("/divisions/create");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->access = Helpers::checkaccess('users', 'edit');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }
        //  $json = json_encode($request->eCheck1);

        $divisions = Division::where('active', 1)->get();
        $divisions2 = Division::where('default_access', $id)->get();
        $js = json_encode($divisions2);
        $roles = Role::where('active', 1)->where('id_role', '!=', 99)->get();
        $user_access = Listaccess::where('flag_delete', 0)->get();
        $users = Division::where('id_division', $id)->first();
        return view('division.edit', array(
            'datas'  => array(
                'users' => $users,
                'title' => 'Edit Divisi',
                'divisions' => $divisions,
                'roles' => $roles,
                'user_access' => $user_access,
                'urls' => 'update/'.$id,
            ),
            'id' => $id
        ));
    }

    public function apiGetDataDivisionAccessById($id, Request $request){
        $this->access = Helpers::checkaccess('users_access', 'view');
        if(!$this->access) return response()->json(['data' => [], 'status' => '401'], 200);

        $datas = Division::where('id_division', $id)->get();

        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    public function apiGetDataDivisionAccessById2($id, Request $request){
        $this->access = Helpers::checkaccess('users_access', 'view');
        if(!$this->access) return response()->json(['data' => [], 'status' => '401'], 200);

        $datas = Division::where('id_division', $id)->get();

        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->access = Helpers::checkaccess('users', 'edit');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }

        $json = json_encode($request->eCheck1);
    	$users = Division::find($id);
        $users->division_name = $request->division_name;
        $users->active = $request->active;
        $users->default_access = $json;
        
        if($users->update()){
            Session::flash('message', "Data has been updated");
            return redirect("/divisions");
        }
        else 
            Session::flash('message', "Upps Something Wrong ... please try again !!!");
        return redirect("/divisions/create/$id");
    }
        

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function apigetdatadivi(Request $request){
      
    	$this->access = Helpers::checkaccess('division', 'view');
        if(!$this->access) return response()->json(['data' => [], 'status' => '401'], 200);

		if($request->division_name != null || $request->active != null) {
            $whereraw = '';
            if($request->division_name != null) $whereraw .= " and division_name like '%$request->division_name%'";
            if($request->active != null) $whereraw .= " and active like '%$request->active%'";

    		$whereraw = preg_replace('/ and/', '', $whereraw, 1);
    		$users = Division::whereRaw($whereraw)->get();    	

    	} else {
    		$users = Division::get();
    	}

    	$datas = [];
		foreach($users as $key => $user){
    		$datas[$key] = [
    			'', $user->division_name,$user->active,$user->id_division,$user->flag_delete
    		];
    	}

    	return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    public function apigetdivisi(Request $request){
        // dd("tes");
    	$this->access = Helpers::checkaccess('divisi', 'view');
        if(!$this->access) return response()->json(['data' => [], 'status' => '401'], 200);

    	$datas = Division::get();
    	return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
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
