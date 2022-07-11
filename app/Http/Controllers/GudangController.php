<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\HelpersController as Helpers;
use App\Http\Controllers\AlamatController as Calamat;
use App\Models\Karantina;
use App\Models\list_product;
use App\Models\List_user_gudang;
use App\Models\ListProductKarantina;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    
    {

        $user = User::where('id_role', '!=', 99)->get();
        $product = Product::where('id', '!=', 0)->get();
        // $ss = Kar::all();
        // dd($ss);

     return view("gudang.index", compact('user'),array(
         'datas'  => array(
             'user' => $user,
             'title' => 'Gudang',
             'product' => $product
         )
         ));
            // ));

        // return view('gudang.index');
    }
    public function gudanggetdata(Request $request){
        if($request->nama != null || $request->alamat != null|| $request->alias_gudang != null|| $request->active != null) {
            $whereraw = '';
            if($request->nama != null) $whereraw .= " and nama like '%$request->nama%'";
            if($request->alamat != null) $whereraw .= " and alamat like '%$request->alamat%'";
            if($request->alias_gudang != null) $whereraw .= " and alias_gudang like '%$request->alias_gudang%'";
            if($request->active != null) $whereraw .= " and active like '%$request->active%'";


            $whereraw = preg_replace('/ and/', '', $whereraw, 1);
            $users = Gudang::whereRaw($whereraw)->get();        

        } else {
            $users = Gudang::get();
        }
        // dd($users);

        $datas = [];
        foreach($users as $key => $user){
            $datas[$key] = [
                '', $user->nama,$user->alamat,$user->alias_gudang,$user->active,$user->flag_delete,$user->id
            ];
        }

        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    public function listgudanggetdata($id){ 
        $listProduct  = list_product::with('productss')->where('id_gudang', $id)->get();
        $datas = [];
        $i = 1;
        foreach($listProduct as $key => $product){
            $datas[$key] = [
                $i++,$product->productss[0]->nama,$product->stock
            ];
        }

        return response()->json(['data' => $datas, 'status' => '200'], 200);

}
   

    // nama divisi alias_gudang id_product user active active   
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
      
            'nama' => 'required',
            'alias_gudang' => 'required',
            'alamat' => 'required',
          
        ],[
         'nama.required' => 'Nama Gudang Tidak Boleh Kosong',
         'alias_gudang.required' => 'Alias Gudang  Tidak Boleh Kosong',
         'alamat.required' => 'Alamat Tidak Boleh Kosong',
         
        ]);
         
        if ($validator->fails()) {
         return response()->json(['errors'=>$validator->errors()->all()]);
     }

     $datas = new Gudang();
     $datas->nama = $request->nama;
     $datas->alias_gudang = $request->alias_gudang;
     $datas->alamat = $request->alamat;
     $datas->active = $request->active;


     if($datas->save()){
        // Save id user di list user gudang
        if($request->user_group != ''){
            $explode = explode(', ', $request->user_group);
            foreach($explode as $explode_id){
                if($explode_id == '') continue;

                $cariuser = List_user_gudang::where('id_user', $explode_id)->where('id_gudang', $datas->id)->first(); // cek apakah pernah di input
                if(isset($cariuser->id)) continue;

                $user = new List_user_gudang;
                $user->id_user = $explode_id;
                $user->id_gudang = $datas->id;
                $user->created_at = date('Y-m-d H:i:s');
                $user->save(); // tambah kan user baru berdasarkan id gudang
            }

            
        }
        $products = Product::get();
  
        foreach($products as $product){
            $listProduct = list_product::where('id_gudang', $datas->id)->where('id_product', $product->id)->first();
            if(isset($listProduct->id)) continue;
            else{
                $listProduct = new list_product;
                
                $listProduct->id_gudang =$datas->id;
                $listProduct->id_product =$product->id;
                $listProduct->created_at = date('Y-m-d H:i:s');
                $listProduct->save();
              
            }
            $listProduct_karantina = ListProductKarantina::where('id_gudang', $datas->id)->where('id_product', $product->id)->first();
            if(isset($listProduct_karantina->id)) continue;
            else{
                $listProduct_karantina = new ListProductKarantina;
                
                $listProduct_karantina->id_gudang =$datas->id;
                $listProduct_karantina->id_product =$product->id;
                $listProduct_karantina->created_at = date('Y-m-d H:i:s');
                $listProduct_karantina->save();
              
            }
            

        
        }
                
            }
                    
     return response()->json(['data' => ['success'], 'status' => '200'], 200);

    }
  

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {

        $tatas  = Gudang::with('list_user_gudang')->where('id', $id)->first();
        foreach($tatas->list_user_gudang as $key  => $data){
            $tatas->list_user_gudang[$key]->nama = Calamat::coba($data->id_user);

        }

        return response()->json(['data' => $tatas, 'status' => '200'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {

        
        $tatas  = Gudang::with('list_user_gudang')->where('id', $id)->first();
        foreach($tatas->list_user_gudang as $key  => $data){
            $tatas->list_user_gudang[$key]->nama = Calamat::coba($data->id_user);
        }

      return response()->json(['data' => $tatas, 'status' => '200'], 200);
        // dd($coba);
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
      
            'nama' => 'required',
            'alias_gudang' => 'required',
            'alamat' => 'required',
            'user_group' => 'required',
          
        ],[
         'nama.required' => 'Nama Gudang Tidak Boleh Kosong',
         'alias_gudang.required' => 'Alias Gudang  Tidak Boleh Kosong',
         'alamat.required' => 'Alamat Tidak Boleh Kosong',
         'user_group.required' => 'User Tidak Boleh Kosong',
         
        ]);
         
        if ($validator->fails()) {
         return response()->json(['errors'=>$validator->errors()->all()]);
     }

     $datas = Gudang::where('id', $id)->first();
     $datas->nama = $request->nama;
     $datas->alias_gudang = $request->alias_gudang;
     $datas->alamat = $request->alamat;
     $datas->active = $request->active;


     if($datas->update()){
        // Save id user di list user gudang
        if($request->user_group != ''){
            $explode = explode(', ', $request->user_group);
            // delete list gudang
            List_user_gudang::where('id_gudang', $id)->delete(); // cek 

            foreach($explode as $explode_id){

                if($explode_id == '') continue;
                $cariuser = List_user_gudang::where('id_user', $explode_id)->where('id_gudang', $datas->id)->first(); // cek apakah pernah di input
                if(isset($cariuser->id)) continue;

                $user = List_user_gudang::where('id', $id)->first();

                if(!isset($user->id)) {
                    $user = new List_user_gudang;
                    $user->id_user = $explode_id;
                    $user->id_gudang = $id;
                    $user->created_at = date('Y-m-d H:i:s');
                    $user->save(); // tambah kan user baru berdasarkan id gudang
                } else {
                    $user->id_user = $explode_id;
                    $user->id_gudang = $id;
                    $user->updated_at = date('Y-m-d H:i:s');
                    $user->save(); // Update user berdasarkan id gudang
                }
                
            }
        }


     }
     
                    
     return response()->json(['data' => ['success'], 'status' => '200'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gudang $gudang, Request $request, $id)
    {
        $datas = Gudang::where('id',$id)->first();
        $datas->flag_delete = 1;

        if(isset($request->undeleted)) $datas->flag_delete = 0;
        $datas->save();
    
        return response()->json(['data' => $datas, 'status' => '200'], 200);;
    }
}
