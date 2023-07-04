<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Historique;
use App\Models\Verbatim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class HistoriqueController extends Controller
{
    // get the common datas across page, like the sidebar
    private function commonDatas()
    {
        $getCategory = Category::get();
        $getVerbatim = Verbatim::all();
        $historique_monthYear = Historique::groupBy('month_year')->get('month_year');

        // $historique_monthYear = Historique::join('verbatim', 'verbatim.id_category', '=', '')

        $datas = new stdClass();
        $datas->getCategory =  $getCategory;
        $datas->getVerbatim =  $getVerbatim;
        $datas->historique_monthYear =  $historique_monthYear;

        return $datas;
    }
    // getting view page with all data
    public function getHistorique()
    {
        $getCategory = $this->commonDatas()->getCategory;
        $getVerbatim = $this->commonDatas()->getVerbatim;
        $historique_monthYear = $this->commonDatas()->historique_monthYear;

        return view('admin.historique', compact('getCategory', 'getVerbatim', 'historique_monthYear'));
    }

    // getting Historiquey By Month
    public function getHistoriqueyByMonth($month_year)
    {
        // $highestLowest = Verbatim::select(DB::raw('MAX(positif) as highest, MAX(negatif) as lowest'))->first();

        $historique_by_month = Category::join('verbatim', 'verbatim.id_category', '=', 'category.id_category')
            ->join('historiques', 'historiques.id_verbatim', '=', 'verbatim.id_verbatim')
            ->where('historiques.month_year', '=', $month_year)
            // ->where('id_user', Auth::user()->id)
            ->get();

        return json_encode($historique_by_month);
    }
}
