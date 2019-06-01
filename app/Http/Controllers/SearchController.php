<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('search.index', compact('users'));
    }

    public function show(Request $request)
    {
        dd($request->q);
        return view('search.index', compact('users'));
    }
}
