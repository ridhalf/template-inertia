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
        $parkir = Parking::select('parkings.id','check_in','parking_code'
            ,'no_police','date_in','categories.name as category_name')
            ->join('categories','categories.id','=','parkings.category_id')
            ->where('status','IN')
            ->orderBy('parkings.created_at','DESC')->get();
        return Inertia::render('Parkir/Masuk',[
            'parkir' => $parkir,
            'categories' => $categories
        ]);
    }
    public function keluar(){
        $parkir = Parking::select('parkings.*','categories.name as category_name')
            ->join('categories','categories.id','=','parkings.category_id')
            ->where('status', 'OUT')
            ->orderBy('parkings.updated_at', 'DESC')->get();
        return Inertia::render('Parkir/Keluar',[
            'parkir'=>$parkir
        ]);
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
    public function check_out(Request $request)
    {
        $request->validate([
            'parking_code' => 'required|numeric'
        ],[
            'parking_code.required'=> 'kode parkir harus diisi',
            'parking_code.numeric'=> 'kode parkir harus berupa angka',
        ]);
        $parking = Parking::where('parking_code', 'PKR-' . trim($request->parking_code))
            ->where('status', 'IN')
            ->first();
        if ($parking == null) {
            return redirect()->back()->withErrors(['parking_code'=>'kode parkir salah atau tidak ditemukan']);
        }
        $jam =   floor((strtotime(date('Y-m-d H:i:s')) - strtotime($parking->created_at)) / (60 * 60)) +1;
        $parking->date_out = date('Y-m-d');
        $parking->check_out = date('H:i:s');
        $parking->status = 'OUT';
        $parking->duration = $jam;
        $parking->total_payment = $parking->category->charge + $jam * 2000;
        try {
            $parking->save();
            return redirect()->route('parkir.checkout')->with('success','kendaraan berhasil keluar');
        }catch (QueryException $e){
            Log::error($e);
            return redirect()->route('parkir.checkout')->with('error',$e);
        }
    }
}
