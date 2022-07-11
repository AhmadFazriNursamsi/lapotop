<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Useraccess;
use Auth;
use QrCode;
use DNS1D;
use DNS2D;
use Validator;

class HelpersController extends Controller
{
    public static function getListMenu(){
    	$listmenu = '{
    "data": [{
        "dropdown":"0",
        "url":"dashboard",
        "name":"Dashboard",
        "class":"",
        "icon":"fa fa-tachometer-alt",
        "list_child":[]
    }, { 
        "dropdown":"1",
        "url":"",
        "name":"Master",
        "class":"",
        "icon":"clr-red fa fa-database",
        "list_child":[{
            "dropdown":"0",
            "url":"users",
            "name":"Users",
            "class":"",
            "icon":"clr-blue fa fa-users",
            "list_child":[]
        }, { 
            "dropdown":"0",
            "url":"customers",
            "name":"Customers",
            "class":"",
            "icon":"clr-blue bi bi-person-bounding-box",
            "list_child":[]
        },{ 
            "dropdown":"0",
            "url":"divisions",
            "name":"Division",
            "class":"",
            "icon":"clr-blue bi bi-person-bounding-box",
            "list_child":[]
        },{ 
            "dropdown":"0",
            "url":"gudang",
            "name":"Gudang",
            "class":"",
            "icon":"clr-blue bi bi-person-bounding-box",
            "list_child":[]
        },{ 
            "dropdown":"0",
            "url":"listaccess",
            "name":"List Access",
            "class":"",
            "icon":"clr-blue bi bi-person-bounding-box",
            "list_child":[]
        }]
    }, { 
        "dropdown":"1",
        "url":"",
        "name":"Transaction",
        "class":"",
        "icon":"clr-green fa fa-cogs",
        "list_child":[{
            "dropdown":"0",
            "url":"orders",
            "name":"Orders",
            "class":"",
            "icon":"clr-blue fa fa-tasks",
            "list_child":[]
        }, {
            "dropdown":"0",
            "url":"paketproduct",
            "name":"Paket Product",
            "class":"",
            "icon":"clr-blue fa fa-tasks",
            "list_child":[]
        }, { 
            "dropdown":"0",
            "url":"invoice",
            "name":"Invoice",
            "class":"",
            "icon":"clr-blue fa fa-tasks",
            "list_child":[]
        }]
    }, { 
        "dropdown":"1",
        "url":"",
        "name":"Utility",
        "class":"",
        "icon":"clr-coklat fa fa-wrench",
        "list_child":[{
            "dropdown":"0",
            "url":"config",
            "name":"Config",
            "class":"",
            "icon":"clr-blue fa fa-tasks",
            "list_child":[]
        }, { 
            "dropdown":"0",
            "url":"options",
            "name":"Options",
            "class":"",
            "icon":"clr-blue fa fa-tasks",
            "list_child":[]
        }]
    }]
}';
    	return json_decode($listmenu);
    }

    public static function checkaccess($name_access = '', $key_access = ''){
        if(Auth::user()->id_role == 99) return true;
        if($name_access != '' && $key_access != ''){

            $checkaccess = Useraccess::select('val_access')->where('id_users', Auth::user()->id)->where('name_access', $name_access)->where('key_access', $key_access)->first();
            if(isset($checkaccess->val_access) && $checkaccess->val_access == 1) return true;
        }
        return false;
    }

    public static function access_crudList(){
        return array('view', 'add', 'edit', 'delete', 'import', 'export');
    }

    public function generateqrcode($text = 'Hello', $size = 250){
        $str = QrCode::size($size)->generate($text);
        $re = '/<svg(.*)<\/svg>/m';
        preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

        $svg = '';
        if(isset($matches[0][1])){
            $svg = '<svg '.$matches[0][1].'</svg>';
        } 
        return json_encode(['data' => [$svg], 'status' => '200'], 200);
    }

    public function generateBarcode($text = '0000000000', $tinggi = 60, $jarak_spasi = 3){
        if(is_numeric($text)) {
            $str = DNS1D::getBarcodeSVG($text, 'UPCE', $jarak_spasi, $tinggi);
            $re = '/<svg(.*)<\/svg>/ms';
            preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
            $svg = '';
            if(isset($matches[0][1])){
                $svg = '<svg'.$matches[0][1].'</svg>';
            } 
            return json_encode(['data' => [$svg], 'status' => '200'], 200);
        } else {
            return json_encode(['data' => ['false : is not numeric'], 'status' => '200'], 200);
        }
        
    }
    public static function satuan()
    {
        return array('kg'=>'Kg', 'gr'=>'Gram', 'kwintal'=> 'Kwintal', 'liter'=>'Liter', 'kodi'=>'Kodi', 'lusin'=>'Lusin');
    }

    // // ## Copy this to validator

    // $validator = Validator::make($params = $request->all(), [
    //   'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048'
    // ]);

    // if ($validator->fails()) {
    //   return response()->json(['errors'=>$validator->errors()]);
    // }

    public function uploadImage($request, $imagename='dft'){

        if($request->file() != null) {
            if($request->file('image')) {
                foreach($request->file() as $key => $img){
                    $extention = $img->getClientOriginalExtension();
                    $imageName = $imagename.'.'.$extention; // will be save name $imagename.$extention
                    $img->move(public_path('images/uploads'), $imageName);
                    $i++;
                }
                return true;
            }
        }
        return false;
    }
}
