<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getCategory            = Category::all();
        $categoryWithVerbatim   = DB::table('verbatim')
            ->join('category', 'verbatim.id_category', '=', 'category.id_category')
            ->select('verbatim.*', 'category.title', 'category.id_category')
            ->groupBy('category.id_category')
            ->get();

        // $positif = DB::table('verbatim')
        //     ->join('category', 'verbatim.id_category', '=', 'category.id_category')

        //     ->pluck("verbatim.positif", "verbatim.id_category");

        // $negatif = DB::table('verbatim')
        //     // ->where('verbatim.sentiment', 'negatif')
        //     ->groupBy('verbatim.id_category')
        //     ->pluck('verbatim.negatif')
        //     ->toArray();


        return view('dashboard', compact('getCategory', 'categoryWithVerbatim'));
    }
}
