<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Verbatim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoriqueController extends Controller
{
    //
    public function getHistorique()
    {
        $getCategory = Category::where('id_user', Auth::user()->id)->get();
        $getVerbatim = Verbatim::all();

        return view('admin.historique', compact('getCategory', 'getVerbatim'));
    }
}
