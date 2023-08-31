<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\CategoryEvent;
use App\Models\Verbatim;
use App\Models\Dialogue;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function createCategory()
    // {
    //     $getCategory = Category::all();
    //     $getVerbatim = Verbatim::all();

    //     return view('admin.createCategory', compact('getCategory', 'getVerbatim'));
    // }

    public function category()
    {
        $categories = DB::table('category')
        ->leftJoin('category-event', 'category.id_category', '=', 'category-event.id_category')
        ->leftJoin('event', 'event.id_event', '=', 'category-event.id_event')
        ->leftJoin('verbatim', 'category.id_category', '=', 'verbatim.id_category')
        ->select(
            'category.*',
            'event.name as event_name',
            DB::raw('count(verbatim.id_verbatim) as verbatim_count')
        )
        ->groupBy('event_name', 'category.position')
        ->orderBy('event_name') // Tri par le nom d'événement
        ->get();

        $noCategoryCount = Verbatim::whereNull('id_category')->count();
        $getCategory = Category::orderBy('position')->get();
        $getCategory2 = DB::table('category')
    ->leftJoin('category-event', 'category.id_category', '=', 'category-event.id_category')
    ->leftJoin('event', 'event.id_event', '=', 'category-event.id_event')
    ->select('category.id_category', 'event.name as event_name', 'category.title as category_title')
    ->orderBy('event_name') // Tri par le nom de l'événement
    ->get();
        $getVerbatim = Verbatim::all();
        $events = Event::all();
     
        return view('admin.category', compact('categories', 'noCategoryCount', 'getCategory','getCategory2', 'getVerbatim','events'));
    }

    public function verbatim()
    {
        $getCategory = Category::all();
        return view('admin.verbatim', compact('getCategory'));
    }

    public function createCat(Request $request)
    {
        $eventId= $request->input('event');

     // Check if the category with the same title exists for the same event
     $existingCategory = CategoryEvent::where('id_event', $eventId)
     ->whereHas('category', function ($query) use ($request) {
         $query->where('title', $request->title);
     })
     ->exists();

 if ($existingCategory) {
     return redirect()->back()->with('error', 'Une étape avec ce titre existe déjà dans cet événement');
 }

        $category = new Category();
        $category->title = $request->title;
        // $category->id_user = Auth::user()->id;
        

        $lastCategory = Category::orderBy('position', 'desc')->first();
        $category->position = $lastCategory ? $lastCategory->position + 1 : 1;

        $category->save();

        $categoryEvent = new CategoryEvent();
        $categoryEvent->id_category = $category->id_category; // Use the ID of the newly created category
        $categoryEvent->id_event = $eventId; // Use the selected event ID from the form
        $categoryEvent->save();

        return redirect()->back()->with('success', 'L\'étape a bien été créé');
    }

    public function CreateVerba(Request $request)
    {
        // get count of verbatims in other categories
        // $countVerba = Verbatim::groupBy('id_category')->select('verbatim', DB::raw('count(*) as totalCount'))->get();
        // echo ($countVerba[0]->totalCount);
        // exit;
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
            return response()->json(['message' => 'Verbatim supprimé avec succès'], 200);
        } else {
            return response()->json(['error' => 'La suppression a échoué'], 500);
        }
    }

    public function getVerbatim($id_category)
    {
        $getVerbatim = Verbatim::Where('id_category', $id_category)->pluck("verbatim", 'id_verbatim');
        return json_encode($getVerbatim);
    }
}
