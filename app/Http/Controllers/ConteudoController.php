<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Conteudo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ConteudoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('conteudos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tags = $request->tags;
        $tags = str_replace(' ', '', $tags);
        $tags = explode(',', $tags);

        $categories = array();

        foreach(Categoria::all() as $category) {
            array_push($categories, $category->id);
        }

        $validatedData = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'private' => ['boolean'],
            'category' => ['required', Rule::in($categories)],
            'file' => ['required', 'file'],
        ]);

        $path = $request->file('file')->store('files');

        $categoria = Categoria::where('id', $validatedData['category'])->first();

        $conteudo = new Conteudo();
        $conteudo->titulo = $validatedData['title'];
        $conteudo->descricao = $validatedData['description'];
        $conteudo->nome = $path;
        //TODO
        $conteudo->tipo = "teste";
        $conteudo->user()->associate(Auth::user());
        $conteudo->save();

        $conteudo->category()->attach($categoria);

        return redirect()->back()->withSuccess("Conteúdo adicionado com sucesso!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conteudo  $conteudo
     * @return \Illuminate\Http\Response
     */
    public function show(Conteudo $conteudo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Conteudo  $conteudo
     * @return \Illuminate\Http\Response
     */
    public function edit($cid)
    {
        $conteudo = Conteudo::where('id', $cid)->first();
        return view('conteudos.create', compact('conteudo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conteudo  $conteudo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conteudo $conteudo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conteudo  $conteudo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conteudo $conteudo)
    {
        //
    }
}
