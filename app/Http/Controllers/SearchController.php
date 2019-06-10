<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Conteudo;
use Illuminate\Http\Request;
use function Sodium\add;

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
        $validation = $validatedData['q'];
        $conteudos = Conteudo::where('titulo', 'LIKE', '%' . $validation . '%')->orWhere('descricao', 'LIKE', '%' . $validation . '%')->get();

        foreach($conteudos as $key => $conteudo) {
            if ($conteudo->privado and (!auth()->check() or (!auth()->user()->hasRole('admin') and !$conteudo->isOwner(auth()->user())))) {
                $conteudos->forget($key);
            }
        }

        $categorias = Categoria::where('nome', 'LIKE', '%' . $validation . '%')->get();

        return view('search.index', compact('conteudos'), compact("categorias"));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $conteudos = Conteudo::where('titulo', 'LIKE', '%' . $search . '%')->orWhere('descricao', 'LIKE', '%' . $search . '%')->get();

        foreach($conteudos as $key => $conteudo) {
            if ($conteudo->privado and (!auth()->check() or (!auth()->user()->hasRole('admin') and !$conteudo->isOwner(auth()->user())))) {
                $conteudos->forget($key);
            }
        }

        $resposta = $conteudos;
        $x = array();
        $indice = 0;
        foreach ($conteudos as $conteudo) {
            if ($indice > 5) {
                break;
            } else {
                $x[$indice] = '<a class="dropdown-content"href="' . route('uploads.show', $conteudo->id) . '">' . $conteudo->titulo . "</a>";
                $indice++;
            }
        }

        if ($resposta->count() > 0) {
            return $x;

        } else {
            $x[0] = "Sem Sugestao";
            return ($x);
        }
    }
}
