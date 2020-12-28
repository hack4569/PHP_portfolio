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

//목록
Route::resource('/wine/adm/product_managements', Product_managementController::class);

//제품정보입력 창
Route::get('/wine/adm/product_managements/create', [Product_managementController::class, 'create']);

//제품정보수정 창
Route::get('/wine/adm/product_managements/{product_code}/edit', [Product_managementController::class, 'edit']);

//제품정보저장
Route::post('/wine/adm/product_managements', [Product_managementController::class, 'store']);

//제품정보업데이트
Route::put('/wine/adm/product_managements/{product_code}', [Product_managementController::class, 'update']);

//제품정보삭제
Route::post('/wine/adm/product_managements/destroy', [Product_managementController::class, 'destroy']);
