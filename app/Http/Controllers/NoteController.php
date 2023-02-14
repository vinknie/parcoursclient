<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Verbatim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{

    public function show($id_category) {

        $category = Category::where('id_category', $id_category)->first();
        $getCategory = Category::all();

        // $getverbatim = DB::select('select id_verbatim ,verbatim, positif , neutre , negatif , position from verbatim where id_category =' . $id_category);

        $getverbatim = DB::table('verbatim')
        ->select('verbatim.id_verbatim', 'verbatim.verbatim', 'verbatim.positif', 'verbatim.neutre', 'verbatim.negatif', 'verbatim.position', DB::raw('(SELECT COUNT(*) FROM dialogue WHERE dialogue.id_verbatim = verbatim.id_verbatim) as dialogue_count'))
        ->where('id_category', '=', $id_category)
        ->groupBy('verbatim.position')
        ->get();


        return view('admin.noteVerba', compact('category','getCategory','getverbatim'));
    }

    public function updatepositif(Request $request, $id_verbatim)
    {
        $verbatim = Verbatim::findOrFail($id_verbatim);

        $positif = $request->input('positif');
        $value = $request->input('value');

        $verbatim->update([$positif => $value]);

        return redirect()->back();
    }

    public function updateneutre(Request $request, $id_verbatim)
    {
        $verbatim = Verbatim::findOrFail($id_verbatim);

        $neutre = $request->input('neutre');
        $value = $request->input('value');

        $verbatim->update([$neutre => $value]);

        return redirect()->back();
    }

    public function updatenegatif(Request $request, $id_verbatim)
    {
        $verbatim = Verbatim::findOrFail($id_verbatim);

        $negatif = $request->input('negatif');
        $value = $request->input('value');

        $verbatim->update([$negatif => $value]);

        return redirect()->back();
    }

    public function decreasepositif(Request $request, $id_verbatim)
    {
        $verbatim = Verbatim::findOrFail($id_verbatim);
    
        $positif = $request->input('positif');
        $value = $request->input('value');
    
        if ($verbatim->positif > 0) {
            $verbatim->update([$positif => $verbatim->positif - 1]);
        }
    
        return redirect()->back();
    }

    public function decreaseneutre(Request $request, $id_verbatim)
    {
        $verbatim = Verbatim::findOrFail($id_verbatim);
    
        $neutre = $request->input('neutre');
        $value = $request->input('value');
    
        if ($verbatim->neutre > 0) {
            $verbatim->update([$neutre => $verbatim->neutre - 1]);
        }
    
        return redirect()->back();
    }
    public function decreasenegatif(Request $request, $id_verbatim)
    {
        $verbatim = Verbatim::findOrFail($id_verbatim);
    
        $negatif = $request->input('negatif');
        $value = $request->input('value');
    
        if ($verbatim->negatif > 0) {
            $verbatim->update([$negatif => $verbatim->negatif - 1]);
        }
    
        return redirect()->back();
    }

    public function updatePositionVerba(Request $request)
    {
        $positions = $request->positions;
    
        foreach ($positions as $index => $id_verbatim) {
            Verbatim::where('id_verbatim', $id_verbatim)->update(['position' => $index + 1]);
        }
   
        return response()->json(['success' => true]);
    }

    public function getDialogues(Request $request)
{
    $id_verbatim = $request->id_verbatim;

    $dialogues = DB::table('dialogue')
        ->join('verbatim', 'dialogue.id_verbatim', '=', 'verbatim.id_verbatim')
        ->select('dialogue.*', 'verbatim.id_verbatim','verbatim.verbatim')
        ->where('verbatim.id_verbatim', $id_verbatim)
        ->orderByRaw('positif DESC, neutre DESC, negatif DESC')
        ->get();
    
    return response()->json($dialogues);
}

}
