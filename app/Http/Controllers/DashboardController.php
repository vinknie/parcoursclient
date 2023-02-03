<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $getCategory = Category::all();

        return view('dashboard', compact('getCategory') );
    }
}
