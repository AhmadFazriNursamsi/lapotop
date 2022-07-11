<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Useraccess;

use Auth;
use QrCode;
use DNS1D;
use DNS2D;
use Validator;
use Image;
use ImageResize;
// use Intervention\Image\Facades\Image;



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
            "url":"products",
            "name":"Products",
            "class":"",
            "icon":"clr-blue bi bi-person-bounding-box",
            "list_child":[]
        }, { 
            "dropdown":"0",
            "url":"customers",
            "name":"Customers",
            "class":"",
            "icon":"clr-blue bi bi-person-bounding-box",
            "list_child":[]
        }, { 
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

    // tambahan
    public static function satuan()
    {
        return array('kg'=>'Kg', 'gr'=>'Gram', 'kwintal'=> 'Kwintal', 'liter'=>'Liter', 'kodi'=>'Kodi', 'lusin'=>'Lusin');
    }

    // generateqrcode
    public static function generateqrcode($text = 'Hello', $size = 250)
    {
        $str = QrCode::size($size)->generate($text);
        $files = '/<svg(.*)<\/svg>/m';
        preg_match_all($files, $str, $matches, PREG_SET_ORDER, 0);

        $svg = '';
        if(isset($matches[0][1])){
            $svg = '<svg '.$matches[0][1].'</svg>';
        } 
        return json_encode(['data' => [$svg], 'status' => '200'], 200);
    }
    // generateqrcode


    public static function generateBarcode($text = '0000000000', $tinggi = 60, $jarak_spasi = 3){
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

    // upload image
    public static function uploadImage($request, $imagename='nameprod12222')
    {
        if($request->file() != null) {
            foreach($request->file() as $key => $img)
            {
                $extention = $img->getClientOriginalExtension(); // asli berhasil
                $imageNameExtension = $imagename.'.'.$extention; // will be save name $imagename.$extention asli
                $imgmove = $img->move(public_path('images/uploads'), $imageNameExtension); // asli berhasil
                // dd($img->getRealPath());
                $Thumbnails = 'Thumbnail-'.$imagename.'.'.$extention;
                // $thumbnails = Image::make($imgmove->getRealPath())->resize(50,50)->save('public/images/uploads'. $imagename.'-thumbnail.'.$extention); // asli berhasi;
                // dd($Thumbnails);
                Image::make($imgmove->getRealPath())->resize(250,250)->save('images/uploads/'.$Thumbnails); // asli berhasi;
            }
            return $imageNameExtension;
        }
        return false;
    }

    // GENERATE untuk kode products
    public static function generateKodeProducts($nama = '', $category_id = 0, $brand_id = 0)
    {
        // nama_products, total product berdasarkan kategori, brand products
        if($nama != '' && $category_id != 0 && $brand_id != 0)
        {
            $hasil = self::DapetHurufDepan($nama);
            $total_count = Product::where('category_id', $category_id)->count()+1;
            $untukstrtotime = strtotime(date('YmdHis'));
            return $hasil.$total_count.$brand_id.$untukstrtotime;
        } else {
            return false;
        } 
    }

    public static function DapetHurufDepan($a)
    {
        $words = explode(" ", $a);
        $acronym = "";

        foreach ($words as $w) 
        {
            $acronym .= $w[0];
        }

        return $acronym;
    }
    // untuk kode products

        
    public static function kodeproduk($kode_products = 0) 
    {
        // $kode_products = $kode_products;
        $z = str_replace(str_split('!@#$%^&*()-_=+\|]}[{?"/.:'), "", $kode_products);
        return $z;
    } 

}

