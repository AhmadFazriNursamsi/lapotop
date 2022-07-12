<?php

namespace App\Http\Controllers;

use App\Models\ListPaket;
use Illuminate\Http\Request;
use App\Models\Gudang;
// use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\HelpersController as Helpers;
use App\Http\Controllers\AlamatController as Calamat;
use App\Models\DetailPaket;
use App\Models\list_product;
use App\Models\List_user_gudang;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class PaketProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $satuan = Helpers::satuan();
        $product = Product::where('id', '!=', 0)->get();
      
        return view('paket.index',array(
            'datas'  => array(
                'satuan' => $satuan,
                'title' => 'Gudang',
                'product' => $product
              
            )
            ));
    }
    public function getdata(){
        $paket = ListPaket::get();
        // dd($paket);
            $datas = [];
            $i = 1;
            foreach($paket as $key => $pakets){
                $datas[$key] = [
                   $i++, $pakets->nama_paket, $pakets->id
                ];
                // $datas[$key]++;
            }
    
            return response()->json(['data' => $datas, 'status' => '200'], 200);
    
    ////gambar nama satuan kodeproduct 
    }

    public function getdataproduct($id){

       
        $paket = Product::where('id', $id)->get();
        // dd($paket);
            $datas = [];
            $i = 1;
            foreach($paket as $key => $product){
                $datas[$key] = [
                   $i++,$product->nama,$product->satuan,$product->kode_products,'',$product->id
                ];
            }
    
            return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    public function autocomplete(Request $request)
    {

        
        $p = $request->get('query');
        $data = Product::select("nama", 'id')
                ->where('nama','LIKE',"%{$p}%")
                ->get();
   
        return response()->json($data);
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
    public function store(Request $request){
      
        $validator = Validator::make($request->all(), [
      
             'jumlah.*' => 'required',
             'search' => 'required',
             'selectproduct' => 'required',
             'nama_paket' => 'required|unique:list_paket_produk',
        ],[
            'nama_paket.required' => 'Nama Paket Tidak Boleh Kosong',
            'search.required' => 'Pilih Paket Terlebih Dahulu',
            'nama_paket.unique' => 'Nama Paket Sudah Terdaftar',
            'selectproduct.required' => 'Pilih Paket Terlebih Dahulu',
        ]);
     
    if ($validator->fails()) {
     return response()->json(['errors'=>$validator->errors()->all()]);
    }
        $datas = new ListPaket();
        $datas->nama_paket = $request->nama_paket;
        $datas->created_at = date('Y-m-d H:i:s');
        if($datas->save()){
        $products = Product::get();
        foreach($products as $product){
            if($request->user_group != ''){
                $explode = explode(', ', $request->user_group);
                foreach($explode as $explode_id){
                    if($explode_id == '') continue;
                    
                    $caripaket = DetailPaket::where('id_list_paket', $datas->id)->where('id_product', $explode_id)->first(); // cek apakah pernah di input
                    if(isset($caripaket->id)) continue;
                    $listProduct = new DetailPaket;
                    $listProduct->id_list_paket =$datas->id;
                    $listProduct->id_product =$explode_id;
                    $listProduct->jumlah =$request->jumlah["'id'"][$explode_id];
                    $listProduct->satuan = $product->satuan;
                    $listProduct->created_at = date('Y-m-d H:i:s');
                    $listProduct->save();// tambah kan user baru berdasarkan id gudang
                }   
            }
        }

    }
        return response()->json(['data' => ['success'], 'status' => '200'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ListPaket  $listPaket
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

       $tatas  = ListPaket::with('detailPaket')->where('id', $id)->first();
       $datas = [];
       foreach($tatas->detailPaket as $key  => $data){
         $tatas->detailPaket[$key]->nama = Calamat::detail_paket_id($data->id_product);
         $datas[$key]= [
            $data->nama,$data->jumlah
         ];
       }
        return response()->json(['data' => $datas,$tatas, 'status' => '200'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ListPaket  $listPaket
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tatas  = ListPaket::with('detailPaket')->where('id', $id)->first();
       
        $datas = [];
        $i= 1;
        foreach($tatas->detailPaket as $key  => $data){
          $tatas->detailPaket[$key]->nama = Calamat::detail_paket_id($data->id_product);
          $datas[$key]= [
             $i++,$data->nama,$data->satuan,$data->products[0]->kode_products,$data->jumlah,$data->products[0]->id
          ];
        }
        return response()->json(['data' => $datas,$tatas, 'status' => '200'], 200);
    }
    public function dd($id){
        $paket =  DetailPaket::with('products')->where('id', $id)->get();
            $datas = [];
            $i = 1;
            foreach($paket as $key => $product){
                $datas[$key] = [
                $i++, $paket[0]->products[0]->nama ,$paket[0]->products[0]->satuan,$paket[0]->products[0]->kode_products,$product->jumlah,$paket[0]->products[0]->id 
                ];
            }
    
            return response()->json(['data' => $datas, 'status' => '200'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ListPaket  $listPaket
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, ListPaket $listPaket)
    {
        // dd($id);
        $validator = Validator::make($request->all(), [
            'jumlah.*' => 'required',
            // 'search' => 'required',
            // 'selectproduct' => 'required',
            'nama_paket' => 'required',
       ],[
           'nama_paket.required' => 'Nama Paket Tidak Boleh Kosong',
        //    'search.required' => 'Pilih Paket Terlebih Dahulu',
        //    'nama_paket.unique' => 'Nama Paket Sudah Terdaftar',
        //    'selectproduct.required' => 'Pilih Paket Terlebih Dahulu',
       ]);
    
   if ($validator->fails()) {
    return response()->json(['errors'=>$validator->errors()->all()]);
   }


        $datas = ListPaket::where('id', $id)->first();
        $datas->nama_paket = $request->nama_paket;
        $datas->updated_at = date('Y-m-d H:i:s');
        
        if($datas->update()){
            if($request->user_group != ''){
                $explode = explode(', ', $request->user_group);
                $products = Product::get();
                 DetailPaket::where('id_product', $id)->delete(); // cek
                foreach($explode as $explode_id){
                    // dd($explode_id);
                    if($explode_id == '') continue;
                    $caripaket = DetailPaket::where('id_list_paket', $datas->id)->where('id_product', $explode_id)->first(); // cek apakah pernah di input
                    // dd($caripaket);
                    if(isset($caripaket->id)) continue;
                    // dd($explode_id);

                    $tatas = DetailPaket::where('id', $id)->first();
                    if(!isset($caripaket->id)){
                        $tatas = new DetailPaket;
                        $tatas->id_list_paket =$datas->id;
                        $tatas->id_product =$explode_id;
                        $tatas->jumlah =$request->jumlah["'id'"][$explode_id];
                        $tatas->satuan = $products[0]->satuan;
                        $tatas->updated_at = date('Y-m-d H:i:s');
                        $tatas->save();// tambah kan user baru berdasarkan id gudang
                    }
                    }   
            }
        }             
         return response()->json(['data' => ['success'], 'status' => '200'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ListPaket  $listPaket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ListPaket $listPaket)
    {
        dd($id);
    }
}
