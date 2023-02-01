<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Verbatim;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createCategory()
    {
       return view('createCategory');
    }

    public function category()
    {
       return view('category');
    }

    public function verbatim()
    {
       return view('verbatim');
    }

}
