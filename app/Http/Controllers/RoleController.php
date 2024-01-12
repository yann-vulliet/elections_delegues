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
        if (Auth::user()->role_id <= 2) {
            $users = User::orderBy('result1', 'desc')->get();
            $win1 = User::where('result1', '!=', 0)
                ->orderBy('result1', 'desc')
                ->get();
            // if($win1->count()>=2){
            //     $win1 = $win1[1]->result1;
            //     $win1 = User::where('result1', $win1)
            //     ->get();
            //     $win1first = User::where('result1', '!=', 0)
            //     ->orderBy('result1', 'desc')
            //     ->take(1)
            //     ->get();
            //     $win1 = $win1->merge($win1first);
            // }
            $win2 = User::where('result2', '!=', 0)
                ->orderBy('result2', 'desc')
                ->get();
            if (count($win2) == 0 or $win2[0]->result2 == $win2[1]->result2){
                $win2 = 'Aucun gagnant, relancer le 2ème tour';
            }else if (count($win2) != 0){
                $win2 = $win2[0];
            }else{
            }
            

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
        if (Auth::user()->role_id <= 2) {
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if (Auth::user()->role_id == 1) {
            $role->delete();
            return redirect()->back()->with('message', 'Le role a été supprimé définitivement.');
        } else {
            return redirect()->back()->withErrors(['erreur' => 'Suppression du role impossible']);
        }
    }
}
