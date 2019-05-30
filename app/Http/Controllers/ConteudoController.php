<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Conteudo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use DOMDocument;
use Illuminate\Http\File;

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
        $categories_names = array();

        foreach (Categoria::all() as $category) {
            array_push($categories, $category->id);
            array_push($categories_names, $category->nome);
        }

        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'category.*' => ['required', Rule::in($categories)],
            'file' => 'required|mimetypes:image/gif,image/jpeg,image/bmp,image/png,video/mp4,video/mov,video/avi,video/flv,video/wmv,audio/mpeg,audio/vnd.wav,audio/ogg,application/zip,application/octet-stream,application/x-zip-compressed,multipart/x-zip',
        ]);

        $file = $request->file('file');

        $zipMimeTypes = ['application/zip', 'application/octet-stream', 'application/x-zip-compressed', 'multipart/x-zip'];
        $contentMimeTypes = ['image/gif','image/jpeg','image/bmp','image/png','video/mp4','video/mov','video/avi','video/flv','video/wmv','audio/mpeg','audio/vnd.wav','audio/ogg'];

        //Check if is a ZIP file
        if (in_array($file->getMimeType(), $zipMimeTypes)) {
            $path = $file->store('zipped');
            $storage_path = storage_path() . '\app\\';
            $zip = new ZipArchive;
            $res = $zip->open($storage_path . $path);
            if ($res === TRUE) {
                $unzipped_full_path = $storage_path . 'unzipped\\' . $file->getFilename();
                $unzipped_path = 'unzipped\\' . $file->getFilename();

                $zip->extractTo($unzipped_full_path);
                $zip->close();

                //Delete uploaded zip file
                Storage::delete($path);

                $files_paths = Storage::files($unzipped_path);

                if (sizeof($files_paths) <= 0) {
                    return redirect()->back()->withErrors('Não pode enviar um ficheiro ZIP vazio.');
                }

                //Checks if meta.xml exists and replaces \ with / in path (Storage::files vs default)
                if (!in_array(str_replace('\\', '/', $unzipped_path) . '/meta.xml', $files_paths)) {
                    return redirect()->back()->withErrors('Não pode enviar um ficheiro .zip sem um ficheiro meta.xml!');
                }

                $xml = new DOMDocument();
                $xml->loadXML(Storage::get($unzipped_path . '\meta.xml'), LIBXML_NOBLANKS);

                try {
                    $xml->schemaValidate($storage_path . '\public\\zip_files.xsd');
                } catch (\Exception $exception) {
                    return redirect()->back()->withErrors('Falhou a validação do ficheiro meta.xml com o seguinte erro: ' . $exception->getMessage());
                }

                $xml_files = $xml->getElementsByTagName('file');

                for ($i = 0; $i < $xml_files->count(); $i++) {
                    $file_name = '/' . $xml_files->item($i)->attributes->getNamedItem('name')->nodeValue;
                    $file_title = $xml_files->item($i)->attributes->getNamedItem('title')->nodeValue;
                    $file_description = $xml_files->item($i)->childNodes->item(0)->nodeValue;

                    $xml_categories = $xml_files->item($i)->childNodes->item(1)->childNodes;
                    $file_categories = [];

                    for ($x = 0; $x < $xml_categories->count(); $x++) {
                        $file_category = $xml_categories->item($x)->attributes->getNamedItem('name')->nodeValue;

                        //Checks for valid categories names
                        if (!in_array($file_category, $categories_names)) {
                            return redirect()->back()->withErrors('A categoria ' . $file_category . ' não existe no sistema.');
                        }

                        array_push($file_categories, $file_category);
                    }

                    //Checks for missing files in zip but declared in meta.xml
                    if (!in_array(str_replace('\\', '/', $unzipped_path) . $file_name, $files_paths)) {
                        return redirect()->back()->withErrors('Ficheiro ' . $file_name . ' em falta no ficheiro ZIP.');
                    }

                    $file_object = new File($unzipped_full_path . $file_name);

                    //Checks for valid meme types inside zip contents
                    if(!in_array($file_object->getMimeType(), $contentMimeTypes)) {
                        return redirect()->back()->withErrors('Ficheiro com MIME Type ' . $file_object->getMimeType() . ' não suportado.');
                    }

                    $path_to_store = Storage::putFile('files', $file_object);

                    $conteudo = new Conteudo();
                    $conteudo->titulo = $file_title;
                    $conteudo->descricao = $file_description;
                    $conteudo->nome = $path_to_store;
                    $conteudo->tipo = explode('/', $file_object->getMimeType())[0];
                    $conteudo->user()->associate(Auth::user());
                    $conteudo->save();

                    foreach ($file_categories as $name) {
                        $categoria = Categoria::where('nome', $name)->first();
                        $conteudo->category()->attach($categoria);
                    }
                }

                Storage::deleteDirectory($unzipped_path);

                return redirect()->back()->withSuccess('ZIP importado com sucesso!');
            } else {
                return redirect()->back()->withErrors('Ocorreu um erro na descompressão do ficheiro .zip');
            }
        }

        dd("PAROU");

        //Inserção de conteúdo único
        $path = $file->store('files');

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
