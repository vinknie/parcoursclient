<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Verbatim;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createCategory()
    {
        $getCategory = Category::all();

       return view('createCategory', compact('getCategory'));
    }

    public function category()
    {
       return view('category');
    }

    public function verbatim()
    {
       return view('verbatim');
    }

    public function createCat(Request $request){
        $existingCategory = Category::where('title', $request->title)->first();
        if ($existingCategory) {
            return redirect()->back()->with('error', 'Une étape avec ce titre existe déjà');
        }

        $category = new Category();
        $category->title = $request->title;

        $category->save();

        return redirect()->back()->with('success', 'L\'étape a bien été créé'); 
    }

    public function CreateVerba(Request $request){
        $existingVerba = Verbatim::where('verbatim',$request->verbatim)->first();
        if ($existingVerba) {
            return redirect()->back()->with('error1', 'Un verbatim avec cette intitulé existe déjà');
        }

        $verba = new Verbatim();
        $verba->id_category = $request->id_category;
        $verba->verbatim = $request->verbatim;

        $verba->save();

        return redirect()->back()->with('success1', 'L\'étape a bien été créé'); 
    }
}
