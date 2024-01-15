<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user() and Auth::user()->role_id <= 2) {
            $users = User::orderBy('result1', 'desc')->get();
            $win1 = User::where('result1', '!=', 0)
                ->orderBy('result1', 'desc')
                ->get();
                

            $win2 = User::where('result2', '!=', 0)
                ->where('role_id', '!=', 0)
                ->orderBy('result2', 'desc')
                ->get();            

            $sessions = Session::all();
            $roles = Role::orderBy('id', 'desc')->get();
            return view('role/index', compact('roles', 'users', 'sessions', 'win1', 'win2'));
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
        if (Auth::user() and Auth::user()->role_id <= 2) {
            $request->validate([
                'role' => 'required'
            ]);

            $role = new Role;

            $role->role = $request->input('role');

            $role->save();
    
            return redirect()->back()->with('message', 'Nouveau groupe crée');
        } else {
            return redirect()->back()->withErrors('erreur', 'Vous n\'avez pas les droits administrateurs');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        if (Auth::user() and Auth::user()->role_id <= 2) {
            $request->validate([
                'role' => 'required'
            ]);
    
            $role->role = $request->input('role');
    
            $role->save();
            
            return redirect()->back()->with('message', 'Le groupe a été modifié');
        } else {
            return redirect()->back()->withErrors('erreur', 'Vous n\'avez pas les droits administrateurs');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if (Auth::user() and Auth::user()->role_id == 1) {
            
            $users = User::where('role_id', '=', $role->id)->get();
            foreach ($users as $user){
                $user->role_id = null;
                $user->vote1 = null;
                $user->vote2 = null;
                $user->registeredElection = 0;
                $user->save();
            }

            $role->delete();
            return redirect()->back()->with('message', 'Le groupe a été supprimé définitivement.');
        } else {
            return redirect()->back()->withErrors(['erreur' => 'Suppression du role impossible']);
        }
    }
}
