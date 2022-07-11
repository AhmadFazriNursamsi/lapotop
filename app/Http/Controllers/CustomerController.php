<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\HelpersController as Helpers;
use App\Http\Controllers\AlamatController as Calamat;
use App\Models\Alamat;
use App\Models\Loc_province;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function apigetdatacustomers(Request $request){
    	
        if($request->name != null ||$request->email||$request->no_tlp|| $request->searchactive != null) {
            $whereraw = '';
            if($request->name != null) $whereraw .= " and name like '%$request->name%'";
            if($request->email != null) $whereraw .= " and email like '%$request->email%'";
            if($request->no_tlp != null) $whereraw .= " and no_tlp like '%$request->no_tlp%'";
            if($request->searchactive != null) $whereraw .= " and active like '%$request->searchactive%'";

    		$whereraw = preg_replace('/ and/', '', $whereraw, 1);
    		$users = Customer::whereRaw($whereraw)->get();    	

    	} else {
    		$users = Customer::get();
    	}

    	$datas = [];
		foreach($users as $key => $user){
    		$datas[$key] = [
    			'', $user->name,$user->email,$user->no_tlp,$user->active,$user->flag_delete,$user->id
    		];
    	}

    	return response()->json(['data' => $datas, 'status' => '200'], 200);
    }


    public function index()
    {

        $coba = Customer::all();

     $alamat = Loc_province::where('id', '!=', 0)->get();
   
        // dd($coba);
        return view("customer.index", compact('coba'),array(
            'datas'  => array(
                'alamat' => $alamat,
                'title' => 'Customers'
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
        $this->access = Helpers::checkaccess('customers', 'create');
        if(!$this->access) return response()->json(['data' => [], 'status' => '401'], 200);


        $validator = Validator::make($request->all(), [
      
           'email' => 'unique:customers|email',
           'no_tlp' => 'unique:customers|numeric',
           'name_Provinsi' => 'required',
           'name_kecamatan'=> 'required',
           'name_kelurahan'=> 'required',   
           'name_kelurahan'=> 'required',
           'name_alamat'=> 'required',     
       ],[
   
        'email.unique' => 'Email Sudah Terdaftar!',
        'no_tlp.unique' => 'Nomor Telepon Sudah Terdaftar!',
        'no_tlp.numeric' => 'Nomor Telepon Harus Berbentuk Angka!',
        'name_Provinsi.required' => 'Alamat Provinsi Tidak Boleh Kosong',
        'name_kabupaten.required' => 'Alamat Kabupaten Tidak Boleh Kosong',
        'name_kecamatan.required' => 'Alamat Kecamatan Tidak Boleh Kosong',
        'name_kelurahan.required' => 'Alamat Kelurahan Tidak Boleh Kosong',
        'name_alamat.required' => 'Alamat Detail     Tidak Boleh Kosong',
        
       ]);
        
       if ($validator->fails()) {
        return response()->json(['errors'=>$validator->errors()->all()]);
    }
    // return response()->json(['data' => ['fails'], 'status' => '401'], 200);
        
     $datas = new Customer;
     $datas->name = $request->name;
     $datas->email = $request->email;
     $datas->no_tlp = $request->no_tlp;
     $datas->active = $request->active;

        if($datas->save()){
            $alamat = new Alamat;
            $alamat->province = $request->name_Provinsi;
            $alamat->city = $request->name_kabupaten;
            $alamat->district = $request->name_kecamatan;
            $alamat->village = $request->name_kelurahan;
            $alamat->alamat = $request->name_alamat;
            $alamat->id_customer=$datas->id;

            $alamat->save();
                    
            return response()->json(['data' => ['success'], 'status' => '200'], 200);
        }
        else{

        return response()->json(['data' => ['false'], 'status' => '200'], 200);
        } 
    }


    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showw($id){
        $datas = Customer::where('id', $id)->get();

        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    public function show($id, Customer $customer, Request $request)
    {
            $tatas  = Customer::with('alamats')->where('id', $id)->first();
            foreach($tatas->alamats as $key => $data){
                // dd($data);
                $tatas->alamats[$key]->province = Calamat::alamatgetById($data->province, $request)->original['data'];
                $tatas->alamats[$key]->city = Calamat::alamatgetByIdCity2($data->city)->original['data'];
                $tatas->alamats[$key]->district = Calamat::alamatgetByIdKab2($data->district)->original['data'];
                $tatas->alamats[$key]->village = Calamat::alamatgetByIdKel2($data->village)->original['data'];
            }
      
        return response()->json(['data' => $tatas, 'status' => '200'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Customer $customer)
    {
        $tatas  = Customer::with('alamats')->where('id', $id)->first();
        return response()->json(['data' => $tatas ,'status' => '200'], 200);
 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Customer $customer)
    {
        $this->access = Helpers::checkaccess('users', 'delete');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);


        $validator = Validator::make($request->all(), [
      
            'email' => 'email',
            'no_tlp' => 'numeric',
            'name_Provinsi' => 'required',
            'name_kecamatan'=> 'required',
            'name_kelurahan'=> 'required',   
            'name_kelurahan'=> 'required',
            'name_alamat'=> 'required',     
        ],[
    
         'no_tlp.numeric' => 'Nomor Telepon Harus Berbentuk Angka!',
         'name_Provinsi.required' => 'Alamat Provinsi Tidak Boleh Kosong',
         'name_kabupaten.required' => 'Alamat Kabupaten Tidak Boleh Kosong',
         'name_kecamatan.required' => 'Alamat Kecamatan Tidak Boleh Kosong',
         'name_kelurahan.required' => 'Alamat Kelurahan Tidak Boleh Kosong',
         'name_alamat.required' => 'Alamat Detail     Tidak Boleh Kosong',
         
        ]);
         
        if ($validator->fails()) {
         return response()->json(['errors'=>$validator->errors()->all()]);
     }

        $tatas = Customer::where('id', $id)->first();
        $tatas->name = $request->name;
        $tatas->email = $request->email;
        $tatas->no_tlp = $request->no_tlp;
        $tatas->active = $request->active;


        if($tatas->update()){
            $alamat = Alamat::where('id_customer', $id)->first();
            $alamat->province = $request->name_Provinsi;
            $alamat->city = $request->name_kabupaten;
            $alamat->district = $request->name_kecamatan;
            $alamat->village = $request->name_kelurahan;
            $alamat->alamat = $request->name_alamat;
            $alamat->id_customer=$tatas->id;


 

            $alamat->update();

                    
            return response()->json(['data' => ['success'], 'status' => '200'], 200);
        }else{

            return response()->json(['data' => ['false'], 'status' => '200'], 200);
            } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer, Request $request, $id)
    {
        $this->access = Helpers::checkaccess('customers', 'delete');
        if(!$this->access) return response()->json(['data' => ['false'], 'status' => '401'], 200);

		$datas = Customer::where('id',$id)->first();
        $datas->flag_delete = 1;

        if(isset($request->undeleted)) $datas->flag_delete = 0;
        $datas->save();
    
        return response()->json(['data' => $datas, 'status' => '200'], 200);;
    
    }
}
