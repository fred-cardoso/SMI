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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nomeCat' => 'required|string|unique:categorias,nome',
        ]);

        $categoria = new Categoria();
        $categoria->nome = $validatedData['nomeCat']; //request

        if (auth()->user()->hasRole('simpatizante')) {
            $categoria->secundaria = true;
        } else {
            if ($request->secundaria != "on") {
                $categoria->secundaria = false;
            } else {
                $categoria->secundaria = true;
            }
        }

        $resultado = $categoria->save();

        if($resultado) {
            return redirect()->route('categorias')->withSuccess(__('controllers.cat_create'));
        } else {
            return redirect()->back()->withErrors(__('controllers.error_occured'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Categoria $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        $conteudos = $categoria->content()->paginate(4);
        return view('categorias/show', compact(['categoria', 'conteudos']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Categoria $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria $categoria)
    {
        if (auth()->user()->hasRole('simpatizante')) {
            if(!$categoria->secundaria) {
                abort(404);
            }
        }
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Categoria $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categoria)
    {
        if (auth()->user()->hasRole('simpatizante')) {
            if(!$categoria->secundaria) {
                abort(404);
            }
        }

        $validateData = $request->validate([
            'nomeCat' => 'required|string',
        ]);

        $categoria->nome = $validateData['nomeCat'];

        if (auth()->user()->hasRole('simpatizante')) {
            $categoria->secundaria = true;
        } else {
            if ($request->secundaria != "on") {
                $categoria->secundaria = false;
            } else {
                $categoria->secundaria = true;
            }
        }

        if($categoria->save()) {
            return redirect()->back()->withSuccess(__('controllers.cat_update'));
        } else {
            return redirect()->back()->withErrors(__('controllers.error_occured'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Categoria $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categoria)
    {
        if(auth()->user()->hasRole('simpatizante') and !$categoria->secundaria == 1) {
            abort(404);
        }

        if($categoria->forceDelete()) {
            return redirect()->back()->withSuccess(__('controllers.cat_delete'));
        } else {
            return redirect()->back()->withErrors(__('controllers.error_occured'));
        }
    }
}
