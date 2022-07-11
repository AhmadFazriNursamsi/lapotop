<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Division;
use App\Models\Role;
use App\Models\Useraccess;
use App\Models\Listaccess;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\HelpersController as Helpers;

class UsersController extends AController
{
    public function index(){

    	$this->access = Helpers::checkaccess('users', 'view');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }

    	$datas = User::get();
    	return view('users.index', array(
            'datas'  => $datas,
        ));
    }


    public function create(){

    	$this->access = Helpers::checkaccess('users', 'add');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }

        $divisions = Division::where('active', 1)->get();
        $roles = Role::where('active', 1)->where('id_role', '!=', 99)->get();
        $user_access = Listaccess::where('flag_delete', 0)->get();

    	return view('users.create', array(
            'datas'  => array(
                'users' => array(),
                'divisions' => $divisions,
                'roles' => $roles,
                'user_access' => $user_access,
                'urls' => 'store/',
                // 'urls' => 'update/'.$id,
            ),
            'id' => ''
        ));
    }

    public function store(Request $request){

    	$this->access = Helpers::checkaccess('users', 'add');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }
        $id = '';
        $users = New User;
        $users->name = $request->name;
        $users->username = $request->username;
        $users->mobile = $request->mobile;
        $users->email = $request->email;
        if($request->password == '') 'F1rst@1Sampai1';
        $users->password = Hash::make($request->password);
        $users->active = $request->active;
        $users->id_division = $request->id_division;
        $users->id_role = $request->id_role;

        if($users->save()){
            Session::flash('message', "Data has been added");
        }
        else {
            Session::flash('message', "Upps Something Wrong ... please try again !!!");
            return redirect("/users/create");
        }
        
        if($request->eCheck1){
            $id = $users->id;
            foreach($request->eCheck1 as $key => $userc){
                foreach($userc as $key2 => $ls) {
                    $users_access = Useraccess::where('id_users', $id)->where('name_access', $key)->where('key_access', $key2)->first();
                    if(!isset($users_access->id_access)) $users_access = new Useraccess;
                    $users_access->id_users = $id;
                    $users_access->name_access = $key; 
                    $users_access->key_access = $key2;
                    $users_access->val_access = $ls;
                    $users_access->save();
                }
            }
        }
        
        if($id)
            return redirect("/users/edit/$id");
        else {
            Session::flash('message', "Upps !!! Something Wrong ... please try again !!!");
            return redirect("/users/create");
        }
    }

    public function edit($id){

    	$this->access = Helpers::checkaccess('users', 'edit');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }

        $divisions = Division::where('active', 1)->get();
        $roles = Role::where('active', 1)->where('id_role', '!=', 99)->get();
        $user_access = Listaccess::where('flag_delete', 0)->get();
        $users = User::where('id', $id)->first();
        return view('users.edit', array(
            'datas'  => array(
                'users' => $users,
                'divisions' => $divisions,
                'roles' => $roles,
                'user_access' => $user_access,
                'urls' => 'update/'.$id,
            ),
            'id' => $id
        ));
    }

    public function update($id, Request $request){

    	$this->access = Helpers::checkaccess('users', 'edit');
        if(!$this->access) {
            Session::flash('message', "you don't have permission to access");
            return redirect('/dashboard');  
        }

    	$users = User::find($id);
        $users->name = $request->name;
        $users->username = $request->username;
        $users->mobile = $request->mobile;
        $users->email = $request->email;
        $users->id_division = $request->id_division;
        $users->id_role = $request->id_role;
        if($request->password != ''){
            $users->password = Hash::make($request->password);
        }
        $users->active = $request->active;
        
        if($request->eCheck1){
            foreach($request->eCheck1 as $key => $userc){
                foreach($userc as $key2 => $ls) {
                    $users_access = Useraccess::where('id_users', $id)->where('name_access', $key)->where('key_access', $key2)->first();
                    if(!isset($users_access->id_access)) $users_access = new Useraccess;
                    $users_access->id_users = $id;
                    $users_access->name_access = $key; 
                    $users_access->key_access = $key2;
                    $users_access->val_access = $ls;
                    $users_access->save();
                }
                
            }
        }
        if($users->update()){
            Session::flash('message', "Data has been updated");
        }
        else 
            Session::flash('message', "Upps Something Wrong ... please try again !!!");
        return redirect("/users/edit/$id");
    }

}
