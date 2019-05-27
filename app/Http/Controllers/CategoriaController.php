<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Conteudo;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::all();

        return view('categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoria = new Categoria();
        $categoria->nome = $request->nomeCat; //request


        if($request->secundaria == null){
            $categoria->secundaria = false;
        }

        $resultado = $categoria->save();

        if($resultado) {
            return redirect()->route('indice');
        } else {
            return redirect()->back()->with('erro', 'Ocorreu um erro!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        return view('categorias', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.create', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categoria)
    {
        $categoria->nome = $request->nomeCat;
        if($request->secundaria == null){
            $categoria->secundaria = false;
        }else{
            $categoria->secundaria = true;
        }

        if($categoria->save()) {
            return redirect()->back()->withSuccess('Categoria atualizada com sucesso!');
        } else {
            return redirect()->back()->withErrors('Ocorreu um erro!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categoria)
    {
        if($categoria->forceDelete()) {
            return redirect()->back()->withSuccess('Categoria eliminada com sucesso!');
        } else {
            return redirect()->back()->withErrors('Ocorreu um erro!');
        }
    }
}
