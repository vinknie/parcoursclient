<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Verbatim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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

        return view('admin.createCategory', compact('getCategory'));
    }

    public function category()
    {
        $categories = DB::table('category')
            ->leftJoin('verbatim', 'category.id_category', '=', 'verbatim.id_category')
            ->select('category.*', DB::raw('count(verbatim.id_verbatim) as verbatim_count'))
            ->groupBy('category.id_category')
            ->get();

        $noCategoryCount = Verbatim::whereNull('id_category')->count();

        return view('admin.category', compact('categories', 'noCategoryCount'));
    }

    public function verbatim()
    {
        return view('admin.verbatim');
    }

    public function createCat(Request $request)
    {
        $existingCategory = Category::where('title', $request->title)->first();
        if ($existingCategory) {
            return redirect()->back()->with('error', 'Une étape avec ce titre existe déjà');
        }

        $category = new Category();
        $category->title = $request->title;

        $category->save();

        return redirect()->back()->with('success', 'L\'étape a bien été créé');
    }

    public function CreateVerba(Request $request)
    {
        $existingVerba = Verbatim::where('verbatim', $request->verbatim)->where('id_category', $request->id_category)->first();
        if ($existingVerba) {
            return redirect()->back()->with('error1', 'Un verbatim avec cette intitulé existe déjà dans cette étape');
        }

        $verba = new Verbatim();
        $verba->id_category = $request->id_category;
        $verba->verbatim = $request->verbatim;

        $verba->save();

        return redirect()->back()->with('success1', 'Le verbatim a bien été créé');
    }

    public function editCategory($id_category)
    {
        $getcategory = Category::find($id_category);

        $getverbatim = DB::select('select id_verbatim ,verbatim from verbatim where id_category =' . $id_category);


        return view('admin.category', compact('getcategory', 'getverbatim'));
    }

    public function updateCat(Request $request, $id_category)
    {
        $getcategory = Category::find($id_category);
        $getcategory->title = $request->title;

        $getcategory->save();
        return redirect()->back()->with('success', 'L\'étape a bien été modifié');
    }

    public function updateVerba(Request $request)
    {

        foreach ($request->verbatim as $key => $value) {
            $getverbatim = Verbatim::find($request->id_verbatim[$key]);
            $getverbatim->verbatim = $request->verbatim[$key];

            $getverbatim->save();
        }

        return redirect()->back()->with('success1', 'Les verbatims ont bien été modifié');
    }

    public function editVerbatimWithoutCat()
    {
        $verbatimsWithoutCategory = Verbatim::whereNull('id_category')->paginate(5);
        $getCategory = Category::all();

        return view('admin.category', compact('verbatimsWithoutCategory', 'getCategory'));
    }

    public function updateVerbatimWithoutCat(Request $request)
    {
        foreach ($request->verbatim as $key => $value) {
            $checkVerbatim = Verbatim::where('id_category', $request->id_category[$key])
                ->where('verbatim', $request->verbatim[$key])
                ->first();
            if ($checkVerbatim) {
                return redirect()->back()->with('error', 'Il existe deja un verbatim avec cette intitulé dans l\'étape choisie');
            } else {
                $getverbatim = Verbatim::find($request->id_verbatim[$key]);
                $getverbatim->id_category = $request->id_category[$key];
                $getverbatim->verbatim = $request->verbatim[$key];

                $getverbatim->save();
            }
        }
        return redirect()->back()->with('success1', 'Les verbatims ont bien été modifié');
    }
}
