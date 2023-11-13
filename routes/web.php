<?php

use App\Models\Car;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\RepairsController;
use App\Http\Controllers\GetCarInfoAndRepairsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>'auth'],function(){
    //All Clients
    Route::get('/', [ClientsController::class, 'index'])->name('home');

    //Show single client
    Route::get('/clients/view/{id}',[ClientsController::class,'show'])->name('single');

    //Create new client (VIEW)
    Route::get('/clients/create',[ClientsController::class,'create'])->name('create_client');

    //Create new client (POST)
    Route::post('/clients/create',[ClientsController::class,'store']);

    //Edit client
    Route::get('/clients/edit/{id}',[ClientsController::class,'edit'])->name('edit_client');

    //Update client
    Route::post('/clients/edit/{id}',[ClientsController::class,'update']);

    //Delete client
    Route::delete('/clients/{id}',[ClientsController::class,'destroy']);


    //Create new Car (VIEW)
    Route::get('/cars/create',[CarsController::class,'create'])->name('create_car');

    //Create new client (POST)
    Route::post('/cars/create',[CarsController::class,'store']);

    //Edit car
    Route::get('/cars/edit/{id}/{cId}',[CarsController::class,'edit'])->name('edit_car');
    
    Route::post('/cars/edit/{id}/{cId}',[CarsController::class,'update']);
    
    //Create new repair (VIEW)
    Route::get('/repairs/create/{client}', [RepairsController::class,'create'])->name('repairs');


    //Create new client (POST)
    Route::post('/repairs/create/{client}',[RepairsController::class,'store']);

    //Edit repair
    Route::get('/repair/edit/{id}/{repairId}',[RepairsController::class,'edit'])->name('edit_repair');
    
    Route::post('/repair/edit/{id}/{repairId}',[RepairsController::class,'update']);

    Route::delete('/repair/{id}',[RepairsController::class,'destroy'])->name('repair_destroy');

    Route::post('/get-car-info-and-repairs',[GetCarInfoAndRepairsController::class,'CarInfoAndRepairs']);


    // Route::post('get-car-info', [CarsController::class, 'get_carInfo']);

    // Route::post('get-repair-info',[RepairsController::class,'getRepairInfo']);

});
Route::prefix('adminPanel')->name('adminPanel.')->group(function(){
    Route::get('/',[AdminController::class,'index'])->name('index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
