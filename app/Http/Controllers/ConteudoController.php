<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Conteudo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tinify\Source;
use ZipArchive;
use DOMDocument;
use Illuminate\Http\File;
use yasmuru\LaravelTinify\Facades\Tinify;

class ConteudoController extends Controller
{

    private $categories_ids = array();
    private $categories_names = array();
    private $contentMimeTypes;

    public function __construct()
    {
        foreach (Categoria::all() as $category) {
            array_push($this->categories_ids, $category->id);
            array_push($this->categories_names, $category->nome);
        }

        $this->contentMimeTypes = ['image/gif', 'image/jpeg', 'image/bmp', 'image/png', 'video/mp4', 'video/mov', 'video/avi', 'video/flv', 'video/wmv', 'audio/mpeg', 'audio/vnd.wav', 'audio/ogg'];
    }

    public function home()
    {
        $conteudos = Conteudo::orderBy('created_at', 'desc')->paginate(4);

        foreach($conteudos as $key => $conteudo) {
            if ($conteudo->privado and (!auth()->check() or (!auth()->user()->hasRole('admin') and !$conteudo->isOwner(auth()->user())))) {
                $conteudos->forget($key);
            }
        }

        return view('homepage', compact('conteudos'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conteudos = Conteudo::paginate(8);



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

    public function createBulk()
    {
        $categories = Categoria::all();
        return view('conteudos.createBulk');
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
            'title' => 'required|string',
            'description' => 'required|string',
            'category.*' => ['required', Rule::in($this->categories_ids)],
            'file' => 'required|mimetypes:image/gif,image/jpeg,image/bmp,image/png,video/mp4,video/mov,video/avi,video/flv,video/wmv,audio/mpeg,audio/vnd.wav,audio/ogg,application/zip,application/octet-stream,application/x-zip-compressed,multipart/x-zip',
        ]);

        $file = $request->file('file');

        $path = null;

        //TinyPNG
        if (explode('/', $file->getMimeType())[0] === "image") {
            $result = Tinify::fromBuffer($file->get());

            $filename = uniqid() . '.' . $file->getClientOriginalExtension();

            Storage::put('files' . DIRECTORY_SEPARATOR . $filename, $result->toBuffer());

            $path = 'files' . DIRECTORY_SEPARATOR . $filename;
        } else {
            $path = $file->store('files');
        }

        $conteudo = new Conteudo();

        if ($request->private == null) {
            $conteudo->privado = false;
        } else {
            $conteudo->privado = true;
        }

        $conteudo->titulo = $validatedData['title'];
        $conteudo->descricao = $validatedData['description'];
        $conteudo->nome = $path;
        $conteudo->tipo = explode(DIRECTORY_SEPARATOR, $request->file()['file']->getMimeType())[0];
        $conteudo->user()->associate(Auth::user());
        $conteudo->save();

        if (isset($validatedData['category'])) {
            foreach ($validatedData['category'] as $id) {
                $categoria = Categoria::where('id', $id)->first();
                $conteudo->category()->attach($categoria);
            }
        }

        return redirect()->route('uploads.show', $conteudo->id);
    }

    /**
     * Same as store, but in bulk
     */

    public function storeBulk(Request $request)
    {
        $validatedData = $request->validate([
            'file' => 'required',
        ]);

        $file = $request->file('file');

        $zipMimeTypes = ['application/zip', 'application/octet-stream', 'application/x-zip-compressed', 'multipart/x-zip'];

        //Check if is a ZIP file
        if (!in_array($file->getMimeType(), $zipMimeTypes)) {
            return redirect()->back()->withErrors('Ficheiro enviado não é válido!');
        }

        $path = $file->store('zipped');
        $storage_path = storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;
        $zip = new ZipArchive;
        $res = $zip->open($storage_path . $path);
        if ($res === TRUE) {
            $unzipped_full_path = $storage_path . 'unzipped' . DIRECTORY_SEPARATOR . $file->getFilename();
            $unzipped_path = 'unzipped' . DIRECTORY_SEPARATOR . $file->getFilename();

            $zip->extractTo($unzipped_full_path);
            $zip->close();

            //Delete uploaded zip file
            Storage::delete($path);

            $files_paths = Storage::files($unzipped_path);

            if (sizeof($files_paths) <= 0) {
                return redirect()->back()->withErrors(__('controllers.empty_zip'));
            }

            //Checks if meta.xml exists and replaces \ with / in path (Storage::files vs default)
            if (!in_array($unzipped_path . DIRECTORY_SEPARATOR . 'meta.xml', $files_paths)) {
                return redirect()->back()->withErrors(__('controllers.empty_meta'));
            }

            $xml = new DOMDocument();
            $xml->loadXML(Storage::get($unzipped_path . '\meta.xml'), LIBXML_NOBLANKS);

            try {
                $xml->schemaValidate($storage_path . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'zip_files.xsd');
            } catch (\Exception $exception) {
                return redirect()->back()->withErrors(__('controllers.error_XML') . $exception->getMessage());
            }

            $xml_files = $xml->getElementsByTagName('file');

            for ($i = 0; $i < $xml_files->count(); $i++) {
                $file_name = '/' . $xml_files->item($i)->attributes->getNamedItem('name')->nodeValue;
                $file_title = $xml_files->item($i)->attributes->getNamedItem('title')->nodeValue;
                $file_privacy = $xml_files->item($i)->attributes->getNamedItem('privacy')->nodeValue ?? '';
                $file_description = $xml_files->item($i)->childNodes->item(0)->nodeValue;

                $xml_categories = $xml_files->item($i)->childNodes->item(1)->childNodes;
                $file_categories = [];

                for ($x = 0; $x < $xml_categories->count(); $x++) {
                    $file_category = $xml_categories->item($x)->attributes->getNamedItem('name')->nodeValue;

                    //Checks for valid categories names
                    if (!in_array($file_category, $this->categories_names)) {
                        return redirect()->back()->withErrors(__('controllers.no_category') . $file_category);
                    }

                    array_push($file_categories, $file_category);
                }

                //Checks for missing files in zip but declared in meta.xml
                if (!in_array($unzipped_path . $file_name, $files_paths)) {
                    return redirect()->back()->withErrors(__('controllers.missing_file') . $file_name);
                }

                $file_object = new File($unzipped_full_path . $file_name);

                //Checks for valid meme types inside zip contents
                if (!in_array($file_object->getMimeType(), $this->contentMimeTypes)) {
                    return redirect()->back()->withErrors(__('controllers.mime_type') . $file_object->getMimeType());
                }

                $path_to_store = Storage::putFile('files', $file_object);

                $conteudo = new Conteudo();
                $conteudo->titulo = $file_title;
                $conteudo->descricao = $file_description;
                $conteudo->privado = $file_privacy === 'true' ? 1 : 0;
                $conteudo->nome = $path_to_store;
                $conteudo->tipo = explode(DIRECTORY_SEPARATOR, $file_object->getMimeType())[0];
                $conteudo->user()->associate(Auth::user());
                $conteudo->save();

                foreach ($file_categories as $name) {
                    $categoria = Categoria::where('nome', $name)->first();
                    $conteudo->category()->attach($categoria);
                }
            }

            Storage::deleteDirectory($unzipped_path);

            return redirect()->back()->withSuccess(__('controllers.zip_import_sucess'));
        } else {
            return redirect()->back()->withErrors(__('controllers.error_occured'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Conteudo $conteudo
     * @return \Illuminate\Http\Response
     */
    public function show(Conteudo $conteudo)
    {
        if ($conteudo->privado and !Auth::check()) {
            abort(404);
        }

        if ($conteudo->privado and (!auth()->user()->hasRole('admin') and !$conteudo->isOwner(auth()->user())))
            abort(404);

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
        if (auth()->user()->hasRole('simpatizante') and !$conteudo->isOwner(auth()->user())) {
            abort(404);
        }

        $categories = Categoria::all();
        return view('conteudos.edit', compact(['conteudo', 'categories']));
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
        if (auth()->user()->hasRole('simpatizante') and !$conteudo->isOwner(auth()->user())) {
            return redirect()->back()->withErrors('Não tem permissões para alterar os conteúdos seleccionados!');
        }

        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'category.*' => ['required', Rule::in($this->categories_ids)],
        ]);

        if ($request->private == null) {
            $conteudo->privado = false;
        } else {
            $conteudo->privado = true;
        }

        $conteudo->titulo = $validatedData['title'];
        $conteudo->descricao = $validatedData['description'];
        $conteudo->save();

        $conteudo->category()->detach();

        foreach ($validatedData['category'] as $id) {
            $categoria = Categoria::where('id', $id)->first();
            $conteudo->category()->attach($categoria);
        }

        return redirect()->back()->withSuccess(__('conteudos.edit_suc'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Conteudo $conteudo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conteudo $conteudo)
    {
        if (auth()->user()->hasRole('simpatizante') and !$conteudo->isOwner(auth()->user())) {
            abort(404);
        }

        Storage::delete($conteudo->nome);
        if ($conteudo->forceDelete()) {
            return redirect()->back()->withSuccess(__('conteudos.delete_suc'));
        } else {
            return redirect()->back()->withErrors(__('controllers.error_occured'));

        }
    }

    /**
     * Receives the request so it can mass process multiple content selection operation
     *
     * ATTENTION! This method is dangerous if not properly escaped since the route is not role protected
     */
    public function massChange(Request $request)
    {

        $validatedData = $request->validate([
            'action' => 'required|string|in:download,delete,visibility_private,visibility_public',
            'selected' => 'required',
            'selected.*' => 'exists:conteudos,id',
        ]);

        if ($validatedData['action'] == "delete" && !Auth::user()->hasRole('admin')) {
            return redirect()->back()->withErrors('Não tem permissões para eliminar os conteúdos seleccionados!');
        }

        if (($validatedData['action'] == "visibility_private" or $validatedData['action'] == "visibility_public") && (!Auth::user()->hasRole('admin') and !Auth::user()->hasRole('simpatizante'))) {
            return redirect()->back()->withErrors('Não tem permissões para alterar os conteúdos seleccionados!');
        }

        $conteudos = Conteudo::findMany($validatedData['selected']);

        if (auth()->user()->hasRole('simpatizante')) {
            foreach ($conteudos as $conteudo) {
                if (!$conteudo->isOwner(auth()->user())) {
                    return redirect()->back()->withErrors('Não tem permissões para alterar os conteúdos seleccionados!');
                }
            }
        }

        if ($validatedData['action'] == "download") {

            if (!Storage::exists('download')) {
                Storage::makeDirectory('download');
            }

            $zip = new ZipArchive;
            $storage_path = storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;
            $file_name = $storage_path . 'download' . DIRECTORY_SEPARATOR . Carbon::now()->timestamp . '.zip';

            if ($zip->open($file_name, ZipArchive::CREATE) === TRUE) {
                $output_meta = "<files>";

                foreach ($conteudos as $conteudo) {
                    $output_privacy = $conteudo->privado == 1 ? "privacy='true'" : "";
                    $output_content_name = preg_replace('/[^a-zA-Z0-9-_\.]/', '', Str::lower($conteudo->titulo)) . $conteudo->id . '.' . explode('.', $conteudo->nome)[1];
                    $output_meta = $output_meta . "<file title='" . $conteudo->titulo . "' " . $output_privacy . "name='" . $output_content_name . "'>";

                    if($request->request_description) {
                        $output_meta = $output_meta . "<description>" . $conteudo->descricao . "</description>";
                    }

                    if ($request->request_category === 'on') {
                        $output_meta = $output_meta . "<categories>";

                        foreach ($conteudo->category()->get() as $category) {
                            $output_meta = $output_meta . "<category name='" . $category->nome . "'/>";
                        }

                        $output_meta = $output_meta . "</categories>";
                    }

                    $output_meta = $output_meta . "</file>";

                    $zip->addFile($storage_path . $conteudo->nome, $output_content_name);
                }

                $output_meta = $output_meta . "</files>";


                Storage::put('download' . DIRECTORY_SEPARATOR . 'tempXML.xml', $output_meta);

                if ($request->request_category === 'on' || $request->request_description === 'description') {
                    $zip->addFile($storage_path . DIRECTORY_SEPARATOR . 'download' . DIRECTORY_SEPARATOR . 'tempXML.xml', 'meta.xml');
                }

                $zip->close();

                Storage::delete('download' . DIRECTORY_SEPARATOR . 'tempXML.xml');

                return response()->download($file_name);
            } else {
                return redirect()->back()->withErrors(__('controllers.error_occured'));
            }
        }

        foreach ($conteudos as $conteudo) {
            if ($validatedData['action'] == "visibility_private") {
                $conteudo->privado = 1;
                $conteudo->save();
            }
            if ($validatedData['action'] == "visibility_public") {
                $conteudo->privado = 0;
                $conteudo->save();
            }
            if ($validatedData['action'] == "delete") {
                Storage::delete($conteudo->nome);
                if (!$conteudo->forceDelete()) {
                    return redirect()->back()->withErrors(__('controllers.error_occured'));
                }
            }
        }

        return redirect()->back()->withSuccess(__('conteudos.update_suc'));
    }
}
