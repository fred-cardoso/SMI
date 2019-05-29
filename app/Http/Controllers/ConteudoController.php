<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Conteudo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ConteudoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conteudos = Conteudo::all();
        return view('conteudos.index', compact('conteudos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categoria::all();
        return view('conteudos.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categories = array();

        foreach (Categoria::all() as $category) {
            array_push($categories, $category->id);
        }

        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'category.*' => ['required', Rule::in($categories)],
            'file' => 'required|mimetypes:image/gif,image/jpeg,image/bmp,image/png,video/mp4,video/mov,video/avi,video/flv,video/wmv,application/zip,application/octet-stream,application/x-zip-compressed,multipart/x-zip',
        ]);

        $file = $request->file('file');

        $zipMimeTypes = ['application/zip', 'application/octet-stream', 'application/x-zip-compressed', 'multipart/x-zip'];

        //Check if is a ZIP file
        if (in_array($file->getMimeType(), $zipMimeTypes)) {

            dd(storage_path());

            $path = $file->store('files');
            $zip = new ZipArchive;
            $res = $zip->open('file.zip');
            if ($res === TRUE) {
                $zip->extractTo('/tempzip/extract_path/');
                $zip->close();
                echo 'woot!';
            } else {
                echo 'doh!';
            }
        }

        dd("PAROU");

        $conteudo = new Conteudo();
        $conteudo->titulo = $validatedData['title'];
        $conteudo->descricao = $validatedData['description'];
        $conteudo->nome = $path;
        $conteudo->tipo = explode('/', $request->file()['file']->getMimeType())[0];
        $conteudo->user()->associate(Auth::user());
        $conteudo->save();

        foreach ($validatedData['category'] as $id) {
            $categoria = Categoria::where('id', $id)->first();
            $conteudo->category()->attach($categoria);
        }

        return redirect()->route('uploads.show', $conteudo->id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Conteudo $conteudo
     * @return \Illuminate\Http\Response
     */
    public function show(Conteudo $conteudo)
    {
        return view('conteudos.show', compact('conteudo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Conteudo $conteudo
     * @return \Illuminate\Http\Response
     */
    public function edit(Conteudo $conteudo)
    {
        return view('conteudos.create', compact('conteudo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Conteudo $conteudo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conteudo $conteudo)
    {
        $categories = array();

        foreach (Categoria::all() as $category) {
            array_push($categories, $category->id);
        }

        $validatedData = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'category' => ['required', Rule::in($categories)],
        ]);

        $categoria = Categoria::where('id', $validatedData['category'])->first();

        $conteudo->titulo = $validatedData['title'];
        $conteudo->descricao = $validatedData['description'];
        //TODO
        $conteudo->tipo = "teste";
        $conteudo->save();

        $conteudo->category()->detach();
        $conteudo->category()->attach($categoria);

        return redirect()->back()->withSuccess("Conteúdo editado com sucesso!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Conteudo $conteudo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conteudo $conteudo)
    {
        Storage::delete($conteudo->nome);
        if ($conteudo->forceDelete()) {
            return redirect()->back()->withSuccess('Conteúdo eliminado com sucesso!');
        } else {
            return redirect()->back()->withErrors('Ocorreu um erro!');
        }
    }
}
