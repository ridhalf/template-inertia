<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware('auth')->group(function (){
    Route::get('/',[\App\Http\Controllers\ParkirController::class,'masuk']);
    Route::get('/logout',function (){
        \Illuminate\Support\Facades\Auth::logout();
        return redirect()->route('login');
    });
    Route::get('/user', function () {
        return 'oke';
    });
    Route::get('/parkir/masuk',[\App\Http\Controllers\ParkirController::class,'masuk'])->name('parkir.checkin');
    Route::get('/parkir/keluar',[\App\Http\Controllers\ParkirController::class,'keluar']);
    Route::post('/parkir/check_in',[\App\Http\Controllers\ParkirController::class,'check_in']);

    Route::get('/master/kategori',[\App\Http\Controllers\CategoriesController::class,'index']);
    Route::post('/master/kategori',[\App\Http\Controllers\CategoriesController::class,'store']);
    Route::delete('/master/kategori/{id}',[\App\Http\Controllers\CategoriesController::class,'destroy']);
});
Route::middleware('guest')->group(function (){
    Route::get('/login',function (){
        return \Inertia\Inertia::render('Auth/Login');
    })->name('login');
    Route::post('/login',[AuthController::class,'login']);
    Route::get('/register',function (){
        return \Inertia\Inertia::render('Auth/Register');
    });
});


