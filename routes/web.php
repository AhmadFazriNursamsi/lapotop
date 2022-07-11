<?php
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ApisController;
use App\Http\Controllers\PaketProductController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DivisionControllers;
use App\Http\Controllers\AlamatController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\ListaccessController;
use App\Http\Controllers\PagesQrController;
use App\Http\Controllers\R404Controller;
use App\Http\Controllers\QrcodeController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware'=>'auth'], function(){
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/users', [UsersController::class, 'index'])->name('users');
Route::get('/users/create', [UsersController::class, 'create']);
Route::get('/users/edit/{id}', [UsersController::class, 'edit']);
Route::post('/users/store', [UsersController::class, 'store']);
Route::post('/users/update/{id}', [UsersController::class, 'update']);
Route::post('/users/delete/{id}', [ApisController::class, 'apideleteuserbyid']);
Route::post('/api/usersaccess/{id}', [ApisController::class, 'apiGetDataUserAccessById']);
Route::get('/api/usersaccess2/{id}', [ApisController::class, 'apiGetDataUserAccessById2']);
Route::get('/api/users/getdata', [ApisController::class, 'apigetdatauser']);
Route::get('/api/users/getdatabyid/{id}', [ApisController::class, 'apigetdatauserbyid']);
Route::get('/api/getdivision', [ApisController::class, 'apigetdivisi']);
Route::get('/api/getrole', [ApisController::class, 'apigetrole']);
Route::post('/users/delete/{id}', [ApisController::class, 'apideleteuserbyid']);


Route::get('/listaccess', [ListaccessController::class, 'index'])->name('listaccess');
Route::post('/listaccess/delete/{id}', [ApisController::class, 'apiDeleteListAccessById']);
Route::get('/api/listaccess/getdata', [ApisController::class, 'apiGetDataListAccess']);
Route::post('/api/listaccess/getdatabyid/{id}', [ApisController::class, 'apiGetDataListAccessById']);
Route::post('/api/listaccess/insertdata', [ListaccessController::class, 'apiInsertData']);
Route::post('/api/listaccess/updatedata', [ListaccessController::class, 'apiUpdateData']);
Route::get('/config', [ConfigController::class, 'index'])->name('config');
Route::post('/api/generate/qrcode', [QrcodeController::class, 'generateqrcode']);
    
    
///Division CRUD
Route::get('/api/divi/getdata', [DivisionControllers::class, 'apigetdatadivi']);
Route::get('/api/getdivision', [DivisionControllers::class, 'apigetdivisi']);
Route::get('/division/detail/{id}', [DivisionControllers::class, 'apiDetail']);
Route::get('/division/delete/{id}', [DivisionControllers::class, 'apiDestroy']);
Route::get('/divisions/create', [DivisionControllers::class, 'create']);
Route::post('/divisions/store', [DivisionControllers::class, 'store']);
Route::get('/divisions/edit/{id}', [DivisionControllers::class, 'edit']);
Route::post('/divisions/update/{id}', [DivisionControllers::class, 'update']);
Route::get('/divisions', [DivisionControllers::class, 'index']);
Route::get('/api/divisionaccess/{id}', [DivisionControllers::class, 'apiGetDataDivisionAccessById']);



//Customers CRUD 
Route::get('/api/customers/getdata', [CustomerController::class, 'apigetdatacustomers']);
Route::get('/customers', [CustomerController::class, 'index']);
Route::post('/customers/store', [CustomerController::class, 'store']);
Route::get('/customers/detail/{id}', [CustomerController::class, 'show']);
Route::get('/customers/detaill/{id}', [CustomerController::class, 'showw']);
Route::get('/customers/delete/{id}', [CustomerController::class, 'destroy']);
Route::get('/customers/edit/{id}', [CustomerController::class, 'edit']);
Route::post('/customers/update/{id}', [CustomerController::class, 'update']);



//alamat CRUD 
Route::get('/api/alamatgetByIdProv/{id}', [AlamatController::class, 'alamatgetById']);
Route::get('/api/alamatVillage/{id}', [AlamatController::class, 'alamatVillage']);

Route::get('/api/selectDistrict/{id}', [AlamatController::class, 'alamatgetByIdDistrict']);


///SelectOption
Route::post('/api/alamatgetByIdProvinsi', [AlamatController::class, 'alamatgetByIdCity']);
Route::post('/api/alamatgetByIdkabupaten', [AlamatController::class, 'alamatgetByIdKab']);
Route::post('/api/alamatgetByIdkelurahan', [AlamatController::class, 'alamatgetByIdKel']);

//gudang

Route::get('/gudang', [GudangController::class, 'index']);
Route::get('/api/gudang/getdata', [GudangController::class, 'gudanggetdata']);
Route::post('/gudang/store', [GudangController::class, 'store']);
Route::get('/gudang/detail/{id}', [GudangController::class, 'show']);
Route::get('/gudang/delete/{id}', [GudangController::class, 'destroy']);
Route::get('/gudang/edit/{id}', [GudangController::class, 'edit']);
Route::post('/gudang/update/{id}', [GudangController::class, 'update']);
Route::get('/api/tableproduct/edit/{id}', [PaketProductController::class, 'dd']);


Route::get('/api/listProduct/getdata/{id}', [GudangController::class, 'listgudanggetdata']);

/// Paket
Route::get('/paketproduct', [PaketProductController::class, 'index']);
Route::get('/api/paket/getdata', [PaketProductController::class, 'getdata']);
Route::get('/api/tableproduct/getdata/{id}', [PaketProductController::class, 'getdataproduct']);
Route::post('/paket/store', [PaketProductController::class, 'store']);
Route::get('/paket/detail/{id}', [PaketProductController::class, 'show']);
Route::get('/paket/edit/{id}', [PaketProductController::class, 'edit']);
Route::post('/paket/update/{id}', [PaketProductController::class, 'update']);
// Route::get('/paket/delete/{id}', [PaketProductController::class, 'destroy']);
// Route::get('search', [PaketProductController::class, 'index'])->name('search');
Route::get('autocomplete', [PaketProductController::class, 'autocomplete'])->name('autocomplete');



Route::get('/api/changeuser/{id}', [GudangController::class, 'getchangeuser']);


   
});

Route::get('/api/generate/qrcode', [QrcodeController::class, 'generateqrcode']);

Route::get('/404', [R404Controller::class, 'r404']);
Route::get('/405', [R404Controller::class, 'r405']);
Route::get('/500', [R404Controller::class, 'r500']);

require __DIR__.'/auth.php';
