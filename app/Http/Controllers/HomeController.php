<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(User $user)
    {
        $sessions = Session::all();
        $users = User::where('role_id', '=', Auth::user()->role_id)->get(); 
        $user = Auth::user();
        // tous les resultats du groupe
        $win1 = User::where('result1', '!=', 0)
            ->where('role_id', '=', Auth::user()->role_id)
            ->orderBy('result1', 'desc')
            ->get(); 
        
        // Uniquement le 1er et les 2èmes
        if($win1->count()>2){
            $win1 = $win1[1]->result1;
            $win1 = User::where('result1', '=', $win1)
            ->where('role_id', '=', Auth::user()->role_id)
            ->get();
            $win1first = User::where('result1', '!=', 0)
            ->where('role_id', '=', Auth::user()->role_id)
            ->orderBy('result1', 'desc')
            ->take(1)
            ->get();
            $win1 = $win1->merge($win1first);
        }

        $win2 = User::where('result2', '!=', 0)
            ->where('role_id', '=', Auth::user()->role_id)
            ->orderBy('result2', 'desc')
            ->get();

        $win2_2 = '';
        
        if (count($win2) == 1){ // Gagnant dès le 1er tour
            $win2 = $win2[0];
            if (isset($win1[0])){
                $win2_2 = $win1[0];
            }else{
            }
        }else if (count($win2) == 0 or $win2[0]->result2 == $win2[1]->result2){ // Égalité au 2ème tour
            $win2 = 'Aucun gagnant, relancer le 2ème tour';
        }else if (count($win2) != 0){ // Gagnant au 2ème tour
            $win2_2 = $win2[1];
            $win2 = $win2[0];
        }else{
        }

        return view('home', compact('users', 'sessions', 'win1', 'win2', 'win2_2'), ['user' => $user]);
    }
}
