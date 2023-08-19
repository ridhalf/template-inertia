<?php

namespace App\Http\Controllers;

use App\Models\Category;
use http\Client\Curl\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories =  Category::all();
        return Inertia::render('Categories/Index',[
            'categories' => $categories
        ]);
    }
    public function datatable(){
        $categories = Category::all();
        return response()->json(['data'=>$categories]);
    }
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'charge' =>'required:numeric'
        ],[
            'name.required'=>'nama harus diisi',
            'charge.required'=>'tarif harus diisi',
            'charge.numeric'=>'tarif harus dalam format angka',
        ]);
        if ($request->id === null){
            $category = new Category();
        }else{
            $category = Category::findOrFail($request->id);
        }
        $category->name = $request->name;
        $category->charge = $request->charge;
        try {
        $category->save();
        return redirect()->route('kategori.index')->with('success','kategori berhasil disimpan');
        }catch (QueryException $e){
            return redirect()->route('kategori.index')->with('error','kategori gagal disimpan');
        }

    }
    public function destroy($id)
    {
        try {
        $category = Category::findOrFail($id);
        $category->delete();
            return redirect('master/kategori')->with('success','data berhasil dihapus');
        }catch (QueryException $e){
            return redirect('master/kategori')->with('error','data tidak dihapus');
        }
    }
}
