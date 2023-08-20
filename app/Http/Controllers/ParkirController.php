<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Parking;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ParkirController extends Controller
{
    public function masuk(){
        $categories = Category::select('id','name')->get();
        $parkir = Parking::all();
        return Inertia::render('Parkir/Masuk',[
            'parkir' => $parkir,
            'categories' => $categories
        ]);
    }
    public function keluar(){
        return Inertia::render('Parkir/Keluar');
    }
    public function check_in(Request $request)
    {
        $request->validate([
            'no_police' => 'required',
            'category_id' => 'required'
        ],[
            'no_police.required' =>'no polisi harus diisi',
            'category_id.required' =>'kategori harus diisi'
        ]);
        $parking = Parking::where('no_police',trim($request->no_police))->where('status','IN')->count();
        if($parking === 1){
            return redirect()->back()->withErrors(['no_police'=>'kendaraan belum checkout']);
        }
        $parking = new Parking();
        $parking->no_police = Str::upper(trim($request->no_police));
        $parking->category_id = $request->category_id;
        $parking->parking_code = 'PKR-' . sprintf('%04d', Parking::count() + 1);
        $parking->date_in = date('Y-m-d');
        $parking->check_in = date('H:i:s');
        $parking->status = 'IN';
        try {
            $parking->save();
            return redirect()->route('parkir.checkin')->with('success','parkir disimpan');
        }catch (QueryException $e){
            Log::error($e);
            return redirect()->route('parkir.checkin')->with('error',$e);
        }
    }
}
