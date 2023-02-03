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
}
