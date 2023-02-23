<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Verbatim;
use App\Models\Dialogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HistoriqueController extends Controller
{
    public function getHistorique(){
        return view('admin.historique');
    }

}