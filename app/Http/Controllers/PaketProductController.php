<?php

namespace App\Http\Controllers;

use App\Models\ListPaket;
use Illuminate\Http\Request;
use App\Http\Controllers\AlamatController as Calamat;
use App\Models\DetailPaket;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class PaketProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $product = Product::where('id', '!=', 0)->get();
        return view('paket.index',array(
            'datas'  => array(
                'title' => 'List Paket',
                'product' => $product)
        ));
    }
    public function getdata(){
        $paket = ListPaket::get();
        $datas = [];
        $i = 1;
        foreach($paket as $key => $pakets){
            $datas[$key] = [
                $i++, $pakets->nama_paket, $pakets->id
            ];
        }
        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    public function getdataproduct($id){       
        $paket = Product::where('id', $id)->get();
            $datas = [];
            $i = 1;
            foreach($paket as $key => $product){
                $datas[$key] = [
                   $i++,$product->nama,$product->satuan,$product->kode_products,'',$product->id
                ];
            }
    
        return response()->json(['data' => $datas, 'status' => '200'], 200);
    }
    public function autocomplete(Request $request){
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
                            $listProduct->created_at = date('Y-m-d H:i:s');
                            $listProduct->save();
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
    public function show($id){
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
     * Show the form for editing the specified resource. data
     *
     * @param  \App\Models\ListPaket  $listPaket
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $tatas  = ListPaket::with('detailPaket')->where('id', $id)->first();
        $datas = [];
        $i= 1;
        foreach($tatas->detailPaket as $key  => $data){
          $tatas->detailPaket[$key]->nama = Calamat::detail_paket_id($data->id_product);
          $datas[$key]= [
             $i++,$data->nama,$data->products[0]->satuan,$data->products[0]->kode_products,$data->jumlah,$data->products[0]->id
          ];
        }
        return response()->json(['data' => $datas,$tatas, 'status' => '200'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ListPaket  $listPaket
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'jumlah.*' => 'required',
            'nama_paket' => 'required',
            'user_group' => 'required',
       ],[
           'nama_paket.required' => 'Nama Paket Tidak Boleh Kosong',
           'user_group.required' => 'Pilih Paket Terlebih Dahulu',
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
                DetailPaket::where('id_list_paket', $id)->delete();
                foreach($explode as $explode_id){
                    if($explode_id == '') continue;
                        $tatas = new DetailPaket;
                        $tatas->id_product = $explode_id;
                        $tatas->id_list_paket = $id;
                        $tatas->jumlah = $request->jumlah["'id'"][$explode_id];; 
                        $tatas->created_at = date('Y-m-d H:i:s');
                        $tatas->save();
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
}
