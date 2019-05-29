<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Role;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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

        return redirect()->back()->withSuccess('Utilizador registado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User  ID $uid
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User ID $uid
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.create', compact('user'));
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
            return redirect()->back()->withSuccess('Utilizador atualizado com sucesso!');
        } else {
            return redirect()->back()->withErrors('Ocorreu um erro!');
        }
    }

    public function updateProfile(User $user, Request $request)
    {

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors('Password atual não está correcta.');
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
            //TODO: Change email template
            event(new Registered($user));
        }

        $user->name = $validatedData['name'];
        $user->save();

        return redirect()->back()->withSuccess('Atualizou o seu perfil com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User ID $uid
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->forceDelete()) {
            return redirect()->back()->withSuccess('Utilizador eliminado com sucesso!');
        } else {
            return redirect()->back()->withErrors('Ocorreu um erro!');
        }
    }

    public function subscribeUser(Request $request)
    {
        $user = Auth::user();

        $subed_user = User::find($request->user);

        $subed_id = $subed_user->id;
        //dd($user->user()->syncWithoutDetaching([['subscribed_id' => $subed_id]]));
        if ($request->sub == "Unsubscribe") {
            ;
            // $user->user()->detach(['subed_id' =>[]]);
        } else {
            $user->user()->attach(['lmao' => ['subscribed_id' => $subed_id]]);
        }


        return redirect()->back()->withSuccess('Subscrito com sucesso!');
    }


    public
    function subscribeCategoria(Request $request)
    {
        $user = Auth::user();

        $subed_cat = Categoria::find($request->categoria);

        $cat_id = $subed_cat->id;
        if ($request->sub == "Unsubscribe") {
            $user->categoria()->detach(['categoria_id' => $cat_id]);
        } else {
            $user->categoria()->attach(['categoria_id' => ['categoria_id' => $cat_id]]);
        }


        return redirect()->back()->withSuccess('Subscrito com sucesso!');
    }
}
