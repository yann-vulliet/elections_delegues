<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user() and Auth::user()->role_id <= 2) {
            $roles = Role::orderBy('id', 'desc')->get();
            $users = User::orderBy('role_id', 'desc')->get();
            return view('user/index', compact('users', 'roles'));
        } else {
            return redirect()->back()->withErrors('erreur', 'Vous n\'avez pas les droits administrateurs');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if (Auth::user() and (Auth::user()->id == $user->id or Auth::user()->role_id <= 2)) {
            return view('user/show', ['user' => $user]);
        } else {
            return redirect()->back()->withErrors('erreur', 'Vous n\'avez pas les droits');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        
        if($request->role_id){ //Changement de role sur la page Compte
            $user->role_id = $request->input('role_id');
        }else if (!$request->vote1 and !$request->vote2 and !$request->show){ //Vote blanc pour le 1er tour
            $user->vote1 = now();
        }else if (!$request->vote2 and !$request->show){ //Vote blanc pour le 2ème tour
            $user->vote2 = now();
        }else if ($request->vote1 and !$request->show) { //Vote pour le 1er tour
            $oneVote = User::where('id', '=', $request->vote1)->get();
            $result = $oneVote[0]->result1 + 1;
            $oneVote[0]->result1 = $result;
            $oneVote[0]->save();
            $user->vote1 = now();
        }else if ($request->vote2 and !$request->show) { //Vote pour le 2ème tour
            $oneVote = User::where('id', '=', $request->vote2)->get();
            $result = $oneVote[0]->result2 + 1;
            $oneVote[0]->result2 = $result;
            $oneVote[0]->save();
            $user->vote2 = now();
        }else{ //Mise à jour depuis la page d'accueil
            $request->validate([
                'firstName' => 'required|max:100',
                'lastName' => 'required|max:100',
                'address' => 'required|max:100',
                'zipCode' => 'required|max:100',
                'city' => 'required|max:100'
            ]);

            $filename = "";

            if ($request->hasFile('avatar')) {
                $filenameWithExt = $request->file('avatar')->getClientOriginalName();
                $filenameWithExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('avatar')->getClientOriginalExtension();
                $filename = $filenameWithExt. '_' .time().'.'.$extension;
                $request->file('avatar')->storeAs('public/image', $filename);
                $user->avatar = $filename;
            }

            $user->firstName = $request->input('firstName');
            $user->lastName = $request->input('lastName');
            $user->discord = $request->input('discord');
            $user->address = $request->input('address');
            $user->zipCode = $request->input('zipCode');
            $user->city = $request->input('city');
        }

        $user->save();
        
        return redirect()->back()->with('message', 'Validé');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (Auth::user() and Auth::user()->role_id == 1 and Auth::user()->id != $user->id) {
            $user->delete();
            return redirect()->back()->with('message', 'Le compte a été supprimé définitivement.');
        } else {
            return redirect()->back()->withErrors(['erreur' => 'Suppression du compte impossible']);
        }
    }
}
