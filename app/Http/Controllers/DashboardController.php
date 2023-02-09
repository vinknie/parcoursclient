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
            ->select('verbatim.positif', 'verbatim.negatif', 'verbatim.verbatim', 'category.title', 'category.id_category')
            ->get()
            ->groupBy('id_category')
            ->map(function ($item) {
                return [
                    'title' => $item->first()->title,
                    'positif' => $item->pluck('positif')->toArray(),
                    'negatif' => $item->pluck('negatif')->toArray(),
                    'verbatim' => $item->pluck('verbatim')->toArray(),
                    // 'data' => $item->map(function ($data) {
                    //     return [
                    //         'positif' => $data->positif,
                    //         'verbatim' => $data->verbatim,
                    //     ];
                    // })->toArray(),
                ];
            });

        // $positif = DB::table('verbatim')
        //     ->join('category', 'verbatim.id_category', '=', 'category.id_category')

        //     ->pluck("verbatim.positif", "verbatim.id_category");

        // $negatif = DB::table('verbatim')
        //     // ->where('verbatim.sentiment', 'negatif')
        //     ->groupBy('verbatim.id_category')
        //     ->pluck('verbatim.negatif')
        //     ->toArray();

    
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

    // public function getPercentage(){

    //     $percent   = DB::table('verbatim')
    //     ->join('category', 'verbatim.id_category', '=', 'category.id_category')
    //     ->select('verbatim.positif', 'verbatim.negatif', 'verbatim.verbatim', 'category.title', 'category.id_category')
    //     ->get();
 
    //     return view ('admin.dashboard',compact('percent'));
    // }
}
