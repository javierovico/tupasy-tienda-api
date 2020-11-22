<?php

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmpresaController;
use App\Models\Permiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Authentication
Route::prefix('auth')->group(function(){
    Route::post('login',[AuthController::class,'login']);
    Route::middleware(['auth:api'])->group(function(){
        Route::get('user',[AuthController::class,'getUser']);
        Route::get('logout',[AuthController::class,'logout']);
    });
});

Route::group(['middleware' => ['auth:api']],function (){
    Route::prefix('empresa')->group(function(){
        Route::get('',[EmpresaController::class,'index']);
        Route::prefix('{empresa}')->group(function(){
            Route::prefix('articulo')->group(function (){
                Route::get('',[ArticuloController::class,'index'])->middleware('empresa.permiso:'. Permiso::PERMISO_CODIGO_VER_ARTICULOS);
                Route::post('',[ArticuloController::class,'create'])->middleware('empresa.permiso:'. Permiso::PERMISO_CODIGO_CREAR_ARTICULO);
                Route::prefix('{articulo}')->group(function(){
                    Route::get('',[ArticuloController::class,'show'])->middleware('empresa.permiso:'.Permiso::PERMISO_VER_ARTICULO);
                    Route::put('',[ArticuloController::class,'update'])->middleware('empresa.permiso:'.Permiso::PERMISO_EDITAR_ARTICULO);
                });
            });
            Route::get('',[EmpresaController::class,'show'])->middleware('empresa.permiso:'. Permiso::PERMISO_CODIGO_VER_EMPRESA);
        });
    });
});
