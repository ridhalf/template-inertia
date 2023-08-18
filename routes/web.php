<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return \Inertia\Inertia::render('Categories/Index');
});
Route::get('/login',function (){
    return \Inertia\Inertia::render('Auth/Login');
});
Route::get('/register',function (){
    return \Inertia\Inertia::render('Auth/Register');
});
