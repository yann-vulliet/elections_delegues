<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user() and Auth::user()->role_id <= 2) {
            $sessions = Session::all();
            return view('session/index', compact('sessions'));
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

            $userId = $request->input('userId', []);
            foreach ($userId as $id) {
                $user = User::find($id);
                $user->registeredElection = 1;
                $user->save();
            }

            $request->validate([
                'role' => 'required'
            ]);

            $vote1 = $request->input('vote1');
            $vote2 = $request->input('vote2');
            $role = $request->input('role');

            $session = new Session;

            $vote1 = strtotime('1970-01-01 '.$vote1.':00') + strtotime(now());
            $vote1 = date('Y-m-d H:i:s', $vote1);

            $session->vote1 = $vote1;
            $session->role_id = $role;

            $session->save();

            return redirect()->back()->with('message', 'Session d\'élection créé');
        } else {
            return redirect()->back('index')->withErrors('erreur', 'Vous n\'avez pas les droits administrateurs');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Session $session)
    {
        return view('session.show', ['session' => $session]);
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
    public function update(Request $request, Session $session)
    {
        
        if (Auth::user() and Auth::user()->role_id <= 2) {
            $userId = $request->input('userId', []);
            foreach ($userId as $id) {
                $user = User::find($id);
                $user->registeredElection = 1;
                $user->save();
            }

            $winner = $request->input('winner');
            $vote1 = $request->input('vote1');
            $vote2 = $request->input('vote2');
            $role = $request->input('role');

            $vote1 = strtotime('1970-01-01 '.$vote1.':00') + strtotime(now());
            $vote1 = date('Y-m-d H:i:s', $vote1);
            $vote2 = strtotime('1970-01-01 '.$vote2.':00') + strtotime(now());
            $vote2 = date('Y-m-d H:i:s', $vote2);

            if ($vote1 and $vote1 > now()){
                $session->vote1 = $vote1;
            }elseif ($vote2 and $vote2 > now()){
                $session->vote2 = $vote2;
            }else{
                if (isset($winner)){
                    $user = User::where('result1', '!=', 0)
                    ->orderBy('result1', 'desc')
                    ->take(1)
                    ->get();
                    $user[0]->result2 = intval($winner);
                    $session->vote2 = now();
                    $user[0]->save();
                }else{
                    return redirect()->back('index')->withErrors('erreur', 'Veuillez entrer un temps');
                }
            }

            $session->role_id = $role;

            $session->save();

            return redirect()->back()->with('message', 'Session d\'élection modifié');
        } else {
            return redirect()->back('index')->withErrors('erreur', 'Vous n\'avez pas les droits administrateurs');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (Auth::user() and Auth::user()->role_id == 1) {
            $user->delete();
            return redirect()->back()->with('message', 'La session de groupe a été supprimé définitivement.');
        } else {
            return redirect()->back()->withErrors(['erreur' => 'Suppression de la session de groupe impossible']);
        }
    }
}
