<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Verbatim;
use App\Models\Dialogue;
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
        $getVerbatim = Verbatim::all();

        return view('admin.createCategory', compact('getCategory', 'getVerbatim'));
    }

    public function category()
    {
        $categories = DB::table('category')
            ->leftJoin('verbatim', 'category.id_category', '=', 'verbatim.id_category')
            ->select('category.*', DB::raw('count(verbatim.id_verbatim) as verbatim_count'))
            ->groupBy('category.position')
            ->get();

        $noCategoryCount = Verbatim::whereNull('id_category')->count();
        $getCategory = Category::orderBy('position')->get();
        $getVerbatim = Verbatim::all();

        return view('admin.category', compact('categories', 'noCategoryCount', 'getCategory', 'getVerbatim'));
    }

    public function verbatim()
    {
        $getCategory = Category::all();
        return view('admin.verbatim', compact('getCategory'));
    }

    public function createCat(Request $request)
    {
        $existingCategory = Category::where('title', $request->title)->first();
        if ($existingCategory) {
            return redirect()->back()->with('error', 'Une étape avec ce titre existe déjà');
        }

        $category = new Category();
        $category->title = $request->title;

        $lastCategory = Category::orderBy('position', 'desc')->first();
        $category->position = $lastCategory ? $lastCategory->position + 1 : 1;

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

        $lastVerbatim = Verbatim::where('id_category', $request->id_category)->orderBy('position', 'desc')->first();
        $verba->position = $lastVerbatim ? $lastVerbatim->position + 1 : 1;

        $verba->save();

        return redirect()->back()->with('success1', 'Le verbatim a bien été créé');
    }

    public function editCategory($id_category)
    {
        $getcategory = Category::find($id_category);

        $getverbatim = DB::select('select id_verbatim ,verbatim from verbatim where id_category =' . $id_category);

        $getCategory = Category::all();

        return view('admin.category', compact('getcategory', 'getverbatim', 'getCategory'));
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

                $lastVerbatim = Verbatim::where('id_category', $request->id_category[$key])->orderBy('position', 'desc')->first();
                $getverbatim->position = $lastVerbatim ? $lastVerbatim->position + 1 : 1;

                $getverbatim->save();
            }
        }
        return redirect()->back()->with('success1', 'Les verbatims ont bien été modifié');
    }


    public function updateCategoryPositions(Request $request)
    {
        $positions = $request->positions;
        foreach ($positions as $index => $id_category) {
            Category::where('id_category', $id_category)->update(['position' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    public function createDialogue(Request $request)
    {
        $existingDial1 = Dialogue::where('dialogue', $request->dialogue)->where('id_verbatim', $request->id_verbatim)->first();

        if ($existingDial1) {
            return redirect()->back()->with('error2', 'Un dialogue avec cette intitulé existe déjà dans ce verbatim');
        }

        $dial = new Dialogue();
        $dial->id_verbatim = $request->id_verbatim;
        $dial->dialogue = $request->dialogue;
        if ($request->input('sentiment') === 'positif') {
            $dial->positif = 1;
            // Verbatim::where('id_verbatim', $request->id_verbatim)->increment('positif');
        } elseif ($request->input('sentiment') === 'neutre') {
            $dial->neutre = 1;
            // Verbatim::where('id_verbatim', $request->id_verbatim)->increment('neutre');
        } elseif ($request->input('sentiment') === 'negatif') {
            $dial->negatif = 1;
            // Verbatim::where('id_verbatim', $request->id_verbatim)->increment('negatif');
        }

        $dial->save();

        return redirect()->back()->with('success2', 'Le dialogue a bien été créé');
    }



    //Delete Function 
    public function deleteCat($id_category)
    {

        $deleteCat = Category::find($id_category)->delete();

        return redirect()->back()->with('delete', 'Etapes supprimé , les verbatims de la catégory se trouve dans "sans étape"');
    }

    public function deleteVerba($id_verbatim)
    {
        $delete = DB::table('verbatim')->where('id_verbatim', $id_verbatim)->delete();
        if ($delete) {
            return response()->json(['success' => 'Verbatim supprimé avec succès']);
        } else {
            dd('La suppression a échoué');
            return response()->json(['error' => 'La suppression a échoué']);
        }

}

    public function getVerbatim($id_category){
        $getVerbatim = Verbatim::Where('id_category',$id_category)->pluck("verbatim",'id_verbatim');
        return json_encode($getVerbatim);
    }



}
