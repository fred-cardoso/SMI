<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Role;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Display a listing of banned users.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexBanned()
    {
        $users = User::where('banned', '1')->get();
        return view('users.banned', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $groupsCollection = Role::all();

        $groups = array();

        foreach ($groupsCollection as $group) {
            array_push($groups, $group->name);
        }

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'group' => [Rule::in($groups)],
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        //Sends a event for email verification listeners

        event(new Registered($user));

        $user_role = Role::where('name', $request->group)->first();
        $user->roles()->attach($user_role);

        return redirect()->back()->withSuccess(__('controllers.register_user'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User  ID $uid
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $conteudos = $user->contents()->get()->filter(function ($item) {
            if ($item->privado) {
                if (!Auth::check()) {
                    return;
                }
                if (Auth::user()->hasRole('admin') or ($item->user()->first()->id == Auth::user()->id)) {
                    return $item;
                }
            }
            return $item;
        });;
        return view('users.show', compact(['user', 'conteudos']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User ID $uid
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact(['user', 'roles']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\User ID $uid
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request)
    {
        $groupsCollection = Role::all();

        $groups = array();


        foreach ($groupsCollection as $group) {
            array_push($groups, $group->name);
        }

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'group' => [Rule::in($groups)],
        ]);

        $user->load('roles');
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        $user->roles()->detach();

        $user_role = Role::where('name', $request->group)->first();
        $user->roles()->attach($user_role);

        if ($user->save()) {
            return redirect()->back()->withSuccess(__('controllers.user_update'));
        } else {
            return redirect()->back()->withErrors(__('controllers.error_occured'));
        }
    }

    public function updateProfile(User $user, Request $request)
    {

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(__(''));
        }

        $validatedData = null;

        if (strlen($request->password) > 0) {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['string', 'min:8', 'confirmed'],
            ]);

            $user->password = Hash::make($validatedData['password']);
        } else {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
            ]);
        }

        if ($user->email != $validatedData['email']) {
            $user->email = $validatedData['email'];
            $user->email_verified_at = null;

            //Sends a event for email verification listeners
            event(new Registered($user));
        }

        $user->name = $validatedData['name'];
        $user->save();

        return redirect()->back()->withSuccess(__('controllers.update_profile'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User ID $uid
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $conteudos = $user->contents()->get();

        //Delete user contents from disk
        foreach($conteudos as $conteudo) {
            Storage::delete($conteudo->nome);
            $conteudo->forceDelete();
        }

        if ($user->forceDelete()) {
            return redirect()->back()->withSuccess(__('controllers.delete_user'));
        } else {
            return redirect()->back()->withErrors(__('controllers.error_occured'));
        }
    }

    public function subscribeCategoria(Request $request)
    {
        $user = Auth::user();

        $subed_cat = Categoria::find($request->categoria);

        $cat_id = $subed_cat->id;
        if ($request->sub == "Unsubscribe") {
            $user->categoria()->detach(['categoria_id' => $cat_id]);
            $subbed = __('categorias.unsub');
        } else {
            $user->categoria()->attach(['categoria_id' => ['categoria_id' => $cat_id]]);
            $subbed = __('categorias.sub');
        }

        return redirect()->back()->withSuccess($subbed);
    }

    public function unbanUser(User $user) {
        $user->banned = false;
        $user->save();

        return redirect()->back()->withSuccess(__('controllers.user_update'));
    }

    public function banUser(User $user) {
        $user->banned = true;
        $user->save();

        return redirect()->back()->withSuccess(__('controllers.user_update'));
    }
}
