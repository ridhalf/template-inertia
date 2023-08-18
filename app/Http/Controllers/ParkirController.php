<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ParkirController extends Controller
{
    public function masuk(){
        return Inertia::render('Parkir/Masuk');
    }
    public function keluar(){
        return Inertia::render('Parkir/Keluar');
    }
}
