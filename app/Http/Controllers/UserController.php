<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

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

        $user_role = Role::where('name',$request->group)->first();
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

        $current_user_role = Role::where('slug', $user->roles->first()->slug)->first();
        $user->roles()->detach($current_user_role);

        $user_role = Role::where('name',$request->group)->first();
        $user->roles()->attach($user_role);

        if($user->save()) {
            return redirect()->back()->withSuccess('Utilizador atualizado com sucesso!');
        } else {
            return redirect()->back()->withErrors('Ocorreu um erro!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User ID $uid
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->forceDelete()) {
            return redirect()->back()->withSuccess('Utilizador eliminado com sucesso!');
        } else {
            return redirect()->back()->withErrors('Ocorreu um erro!');
        }
    }

}
