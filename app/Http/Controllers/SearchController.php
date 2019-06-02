<?php

namespace App\Http\Controllers;

use App\Categoria;
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
        $conteudos = Conteudo::where('titulo', 'LIKE', '%'.$validation.'%')->orWhere('descricao', 'LIKE', '%'.$validation.'%')->get();
        $categorias = Categoria::where('nome', 'LIKE', '%'.$validation.'%')->get();


        //dd($categorias);
        //dd($pesquisa);


        //dd($pesquisa);
        return view('search.index', compact('conteudos'),compact("categorias"));
    }
}
