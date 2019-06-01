<?php

namespace App\Http\Controllers;

use App\Conteudo;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('search.index', compact('users'));
    }

    public function show(Request $request)
    {
        $validatedData = $request->validate([
            'q' => ['required', 'string', 'max:255']
        ]);
        $validation =$validatedData['q'];
        $pesquisa = Conteudo::where('titulo', 'LIKE', '%'.$validation.'%')->orWhere('descricao', 'LIKE', '%'.$validation.'%')->get();


        //dd($pesquisa);
        return view('search.index', compact('pesquisa'));
    }
}
