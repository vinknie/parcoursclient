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
            
          $totalEachVerbatim   = DB::table('verbatim')
        ->join('category', 'verbatim.id_category', '=', 'category.id_category')
        ->select(
            'verbatim.positif', 
            'verbatim.negatif',
            'verbatim.neutre', 
            'verbatim.verbatim',
            'verbatim.position', 
            'category.title', 
            'category.id_category',
            'category.position',
            DB::raw('sum(verbatim.positif + verbatim.negatif + verbatim.neutre) as total')
        )
        ->orderBy('category.position','asc')
        ->orderBy('verbatim.position','asc')
        ->groupBy('verbatim.id_verbatim')
        ->get();

        $totalEachCategory   = DB::table('verbatim')
        ->join('category', 'verbatim.id_category', '=', 'category.id_category')
        ->select(
            'category.title', 
            'category.id_category',
            'category.position',
            DB::raw('sum(verbatim.positif + verbatim.negatif + verbatim.neutre) as total')
        )
        ->orderBy('category.position','asc')
        ->orderBy('verbatim.position','asc')
        ->groupBy('category.id_category')
        ->get();

        foreach ($totalEachVerbatim as $verbatim) {
            foreach ($totalEachCategory as $category) {
                if ($verbatim->id_category === $category->id_category) {
                    $percent = ($verbatim->total / $category->total) * 100;
                }
            }
            $verbatim->percent = $percent;
        }
       

        return view('admin.dashboard', compact('getCategory', 'categoryWithVerbatim','totalEachVerbatim','totalEachCategory','percent'));
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
