<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Verbatim;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // fullchart page
    public function fullChart()
    {
        $getCategory                = Category::all();
        $categoryWithVerbatim       = DB::table('verbatim')
            ->join('category', 'verbatim.id_category', '=', 'category.id_category')
            ->select(
                'verbatim.positif',
                'verbatim.negatif',
                'verbatim.verbatim',
                'verbatim.id_verbatim',
                'category.title',
                'category.id_category',
                'category.position',
            )
            ->where('category.id_user', '=', Auth::user()->id)
            ->orderBy('verbatim.position', 'asc')
            ->orderBy('category.position', 'asc')
            ->get()
            ->groupBy('id_category')
            ->map(function ($item) {
                return [
                    'title' => $item->first()->title,
                    'positif' => $item->pluck('positif')->toArray(),
                    'negatif' => $item->pluck('negatif')->toArray(),
                    'verbatim' => $item->pluck('verbatim', 'id_verbatim')->toArray(),
                    'catPosition' => $item->pluck('position')
                ];
            });



        $verbatimCountByCategory    = Verbatim::selectRaw('count(*) as total_by_cat')
            ->join('category', 'verbatim.id_category', '=', 'category.id_category')
            ->orderBy('category.position', 'asc')
            ->orderBy('verbatim.position', 'asc')
            ->groupBy('verbatim.id_category')
            ->get();

        $highestLowest = Verbatim::select(DB::raw('MAX(positif) as highest, MAX(negatif) as lowest'))->first();

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
            ->orderBy('category.position', 'asc')
            ->orderBy('verbatim.position', 'asc')
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
            ->orderBy('category.position', 'asc')
            ->orderBy('verbatim.position', 'asc')
            ->groupBy('category.id_category')
            ->get();


        foreach ($totalEachVerbatim as $verbatim) {
            foreach ($totalEachCategory as $category) {
                if ($verbatim->id_category === $category->id_category) {
                    if ($category->total > 0) {
                        $percent = ($verbatim->total / $category->total) * 100;
                    } else {
                        $percent = 0;
                    }
                }
            }
            $verbatim->percent = $percent;
        }

        if (!isset($percent)) {
            return view('admin.charts.fullChart', compact('getCategory', 'categoryWithVerbatim', 'highestLowest', 'verbatimCountByCategory', 'totalEachVerbatim'));
        }
        return view('admin.charts.fullChart', compact('getCategory', 'categoryWithVerbatim', 'highestLowest', 'verbatimCountByCategory', 'totalEachVerbatim', 'percent'));
    }

    public function getDialogues(Request $request)
    {
        $id_verbatim = $request->id_verbatim;

        $dialogues = DB::table('dialogue')
            ->join('verbatim', 'dialogue.id_verbatim', '=', 'verbatim.id_verbatim')
            ->select('dialogue.*', 'verbatim.id_verbatim', 'verbatim.verbatim')
            ->where('verbatim.id_verbatim', $id_verbatim)
            ->orderByRaw('positif DESC, neutre DESC, negatif DESC')
            ->get();

        return response()->json($dialogues);
    }

    // old chart click bar modal
    public function popup_chart($id_verbatim)
    {
        $dialogues = $this->getDialogues(new Request(['id_verbatim' => $id_verbatim]));

        // Ensuite, vous pouvez retourner la vue avec les dialogues en utilisant la méthode view() de Laravel
        return $dialogues;
    }

    // echarts popup function
    public function popup_chart_verbaName($verbaName)
    {
        return json_encode('tenzin' + $verbaName);
    }


    public function test()
    {
        $getCategory = Category::all();
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
                DB::raw('sum(verbatim.positif + verbatim.negatif + verbatim.neutre) as total'),
            )
            ->orderBy('category.position', 'asc')
            ->orderBy('verbatim.position', 'asc')
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
            ->orderBy('category.position', 'asc')
            ->orderBy('verbatim.position', 'asc')
            ->groupBy('category.id_category')
            ->get();

        foreach ($totalEachVerbatim as $verbatim) {
            foreach ($totalEachCategory as $category) {
                if ($verbatim->id_category === $category->id_category) {
                    if ($category->total > 0) {
                        $percent = ($verbatim->total / $category->total) * 100;
                    } else {
                        $percent = 0;
                    }
                }
            }
            $verbatim->percent = $percent;
        }
        if (!isset($percent)) {
            return view('admin.charts.fullcharttest', compact('getCategory', 'totalEachCategory', 'totalEachVerbatim'));
        }
        return view('admin.charts.fullcharttest', compact('getCategory', 'totalEachCategory', 'totalEachVerbatim', 'percent'));
    }
}
