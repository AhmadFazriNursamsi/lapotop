<?php
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ApisController;
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

    // Route::get('/api/usersaccess2/{id}', [UsersController::class, 'apiGetDataUserAccessById2']);
    // Route::post('/api/usersaccess/{id}', [UsersController::class, 'apiGetDataUserAccessById']);
    Route::post('/users/delete/{id}', [ApisController::class, 'apideleteuserbyid']);
    
    Route::get('/api/getdivision', [ApisController::class, 'apigetdivisi']);
    Route::get('/api/getrole', [ApisController::class, 'apigetrole']);
    
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
    
    //product   
    Route::get('/products', [ProductsController::class, 'index'])->name('products');
    Route::get('/api/products/getdata', [ProductsController::class, 'apiGetData']);
    Route::get('/api/products/getdatabyid/{id}', [ProductsController::class, 'apiGetDataById']);
    Route::post('api/products/insertdata', [ProductsController::class, 'apiInsertData']);
    Route::post('api/products/updatedata/{id}', [ProductsController::class, 'apiUpdateDataById']);
    Route::post('api/products/delete/{id}', [ProductsController::class, 'apiDeleteProductsById']);
    Route::get('/details/products', [PagesQrController::class, 'showproducts']);

    // LIST ACCESS
    Route::get('/listaccess', [ListaccessController::class, 'index'])->name('listaccess');
    Route::post('/listaccess/delete/{id}', [ListaccessController::class, 'apiDeleteListAccessById']);
    Route::get('/api/listaccess/getdata', [ListaccessController::class, 'apiGetDataListAccess']);
    Route::post('/api/listaccess/getdatabyid/{id}', [ListaccessController::class, 'apiGetDataListAccessById']);
    Route::post('/api/listaccess/insertdata', [ListaccessController::class, 'apiInsertData']);
    Route::post('/api/listaccess/updatedata', [ListaccessController::class, 'apiUpdateData']);

    // CONFIG
    Route::get('/config', [ConfigController::class, 'index'])->name('config');
    Route::get('/api/config/getdata', [ConfigController::class, 'apiGetData']);
    Route::get('/api/config/getdatabyid/{id}', [ConfigController::class, 'apiGetDataById']);
    Route::post('api/config/insertdata', [ConfigController::class, 'apiInsertData']);
    Route::post('api/config/updatedata/{id}', [ConfigController::class, 'apiUpdateDataById']);
    Route::post('api/config/delete/{id}', [ConfigController::class, 'apiDeleteConfigById']);


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

    Route::get('/api/changeuser/{id}', [GudangController::class, 'getchangeuser']);

});

require __DIR__.'/auth.php';

