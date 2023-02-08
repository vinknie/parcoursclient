<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Verbatim;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  dashboard
    public function index()
    {
        $getCategory            = Category::all();
        $categoryWithVerbatim   = DB::table('verbatim')
            ->join('category', 'verbatim.id_category', '=', 'category.id_category')
            ->select('verbatim.positif', 'verbatim.negatif', 'verbatim.verbatim', 'category.title', 'category.id_category')
            ->orderBy('category.position', 'asc')
            ->orderBy('verbatim.position', 'asc')
            ->get()
            ->groupBy('id_category')
            ->map(function ($item) {
                return [
                    'title' => $item->first()->title,
                    'positif' => $item->pluck('positif')->toArray(),
                    'negatif' => $item->pluck('negatif')->toArray(),
                    'verbatim' => $item->pluck('verbatim')->toArray(),
                ];
            });
        return view('admin.dashboard', compact('getCategory', 'categoryWithVerbatim'));
    }

    // fullchart page
    public function fullChart()
    {
        $getCategory            = Category::all();
        $categoryWithVerbatim   = DB::table('verbatim')
            ->join('category', 'verbatim.id_category', '=', 'category.id_category')
            ->select('verbatim.positif', 'verbatim.negatif', 'verbatim.verbatim', 'category.title', 'category.id_category')
            ->orderBy('category.position', 'asc')
            ->orderBy('verbatim.position', 'asc')
            ->get()
            ->groupBy('id_category')
            ->map(function ($item) {
                return [
                    'title' => $item->first()->title,
                    'positif' => $item->pluck('positif')->toArray(),
                    'negatif' => $item->pluck('negatif')->toArray(),
                    'verbatim' => $item->pluck('verbatim')->toArray(),
                ];
            });

        $highestLowest = Verbatim::select(DB::raw('MAX(positif) as highest, MAX(negatif) as lowest'))->first();

        return view('admin.charts.fullChart', compact('getCategory', 'categoryWithVerbatim', 'highestLowest'));
    }
}
