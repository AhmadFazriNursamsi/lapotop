<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use QrCode;
use App\Http\Controllers\HelpersController as Helpers;

class QrcodeController extends Controller
{
    public function generateqrcode(Request $request){

    	dd('oke');

    	// $generateBarcode = Helpers::generateBarcode('0881523611542', 80, 2.8);
    	// echo json_decode($generateBarcode)->data[0];
    	// $getsvgqrcode = Helpers::generateqrcode('Hrc_1asr2195131');
    	// echo json_decode($getsvgqrcode)->data[0];

    	// $csrf = csrf_field();
  //       $validator = Validator::make($params = $request->all(), [
		//   'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048'
		// ]);

		// if ($validator->fails()) {
  //         return response()->json(['errors'=>$validator->errors()]);
  //       }

  //       if ($request->file() != null) {
  //       	$rf = Helpers::uploadImage($request, "nameprod1");
  //       }
    	
    	

    	
    	// if($request->image) {
    	// 	dd($request->image, $request);
    	// 	$imageName = time().'.'.$request->image->extension();  
     //    	// $request->image->move(public_path('images'), $imageName);
     //    	dd($imageName, $request->image);
    	// }

        

    	// echo '<form action="http://localhost/newlaravel/appsv3/public/api/generate/qrcode"  method="post" enctype="multipart/form-data">
    	// '.$csrf.'
    	// <p><input type="file" name="image">
    	// <p><button type="submit">Submit</button></form>';
    }
}
