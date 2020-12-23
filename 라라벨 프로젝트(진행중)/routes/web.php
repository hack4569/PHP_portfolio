<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product_managementController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::resource('/wine/adm/product_managements', Product_managementController::class);

// Route::get('products','Product_managementController@index');
