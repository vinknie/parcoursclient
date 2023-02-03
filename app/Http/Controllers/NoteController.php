<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Verbatim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{

    public function show($id_category) {

        $category = Category::where('id_category', $id_category)->first();
        $getCategory = Category::all();

        $getverbatim = DB::select('select id_verbatim ,verbatim, positif , neutre , negatif from verbatim where id_category =' . $id_category);

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
}
