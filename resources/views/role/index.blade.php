@extends('layouts.app')

<?php 
$now = strtotime(now());
$total = 0;
?>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>test</h2>                        
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <div class="btn btn-primary">Nouveau Groupe</div>
            </a>
            <div class="dropdown-menu dropdown-menu-start mb-8 row mb-8">
                <form class="" action="{{route('roles.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="role">Nouveau Groupe</label>
                    <input class="form-control" type="text" required placeholder="" id="role" name="role" value="">
                </div>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </form>
            </div>
            @foreach ($roles as $role)
            @if ($role->id >= Auth::user()->role_id)
                <hr>
                <div class="d-flex flex-row flex-wrap">
                    <div class="d-flex flex-column left">
                        <h5>{{ $role->role }}</h5>
                    </div>  
                    <div class="btn-admin right">
                        @if ($role->id > 2)
                        @if (count($sessions) == 0 or (!$sessions->contains('role_id', $role->id)))
                        <!-- Jamais eu de vote ou pas de vote pour cette session -->
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <div class="btn btn-primary">Créer un vote</div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end mb-3 row mb-3">
                                    <form class="" action="{{route('sessions.store')}}" method="POST">
                                        @csrf
                                        <div class="mb-3 d-flex">
                                            <div>
                                                <h6>Ajouter des candidats</h6>
                                                <input type="hidden" id="" name="role" value="{{$role->id}}" />
                                                @foreach ($users as $user)
                                                    @if ($user->role_id == $role->id and $user->registeredElection == 0)
                                                        <div>
                                                            <input type="checkbox" id="registeredElection" name="userId[]" value="{{$user->id}}" />
                                                            <label for="registeredElection">{{$user->firstName}}{{$user->lastName}}</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="d-flex flex-column">
                                                <div>
                                                    <label for="vote1">Temps avant la fin du 1er tour dans : </label>
                                                    <input type="time" id="vote1" name="vote1" value="02:00" max="" />
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Démarrer</button>
                                    </form>
                                </div> 
                                <?php $total = 0; ?>
                            @endif
                        @foreach ($sessions as $session)
                            @if ($session->role_id == $role->id and isset($session->vote1) and strtotime($session->vote1)>$now and !isset($session->vote2))
                            <!-- Modifier le 1er vote qui est encore en cours -->
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <div class="btn btn-primary">Vote en cours</div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end mb-3 row mb-3">
                                    <form class="" action="{{route('sessions.update', $session)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3 d-flex">
                                            <div>
                                                <h6>Ajouter des candidats</h6>
                                                <input type="hidden" id="" name="role" value="{{$role->id}}" />
                                                @foreach ($users as $user)
                                                    @if ($user->role_id == $role->id and $user->registeredElection == 0)
                                                        <div>
                                                            <input type="checkbox" id="registeredElection" name="userId[]" value="{{$user->id}}" />
                                                            <label for="registeredElection">{{$user->firstName}}{{$user->lastName}}</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="d-flex flex-column">
                                                <div>
                                                    <label for="vote1">Réinitialiser le temps avant la fin du 1er tour :</label>
                                                    <input type="time" id="vote1" name="vote1" value="02:00" max="" />
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-warning">Modifier</button>
                                    </form>
                                </div> 
                                <?php $total = 0; ?>
                            @endif
                            @if ($role->id == $session->role_id and isset($session->vote1) and strtotime($session->vote1)<$now and !isset($session->vote2))
                            <!-- 1er tour terminé, création du 2ème tour -->
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <div class="btn btn-primary">Fin du 1er tour</div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end mb-3 row mb-3">
                                    <form class="" action="{{route('sessions.update', $session)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3 d-flex">
                                            <div>
                                                <h5>Candidat au 2ème tour :</h5>
                                                <input type="hidden" id="" name="role" value="{{$role->id}}" />
                                                @foreach ($win1 as $user)
                                                    @if ($user->role_id == $role->id and $user->registeredElection == 1)
                                                        <?php $total = $total + $user->result1; ?>
                                                    @endif
                                                @endforeach
                                                @foreach ($win1 as $user)
                                                    @if ($user->role_id == $role->id and $user->registeredElection == 1)
                                                        <div>
                                                            <p>{{$user->firstName}} {{$user->lastName}}
                                                                <b>
                                                                    <?php 
                                                                        $pourcentage = number_format($user->result1 / $total * 100, 0);
                                                                        if ( $pourcentage > 50) {
                                                                            $finish = true;
                                                                        }
                                                                        echo ($pourcentage.'%');
                                                                    ?>
                                                                </b>
                                                            </p> 
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            @if (isset($finish) and  $finish == true)
                                            </div>
                                                <input type="hidden" id="" name="winner" value="1000" />
                                                <button type="submit" class="btn btn-primary">Valider le gagnant</button>
                                            @else
                                            <div class="d-flex flex-column">
                                                <div>
                                                    <label for="vote2">Temps avant la fin du 2ème tour dans : </label>
                                                    <input type="time" id="vote2" name="vote2" value="02:00" max="" />
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Démarrer</button>
                                        @endif
                                    </form>
                                </div>
                                <?php $total = 0; ?>
                            @endif
                            @if ($role->id == $session->role_id and isset($session->vote1) and isset($session->vote2) and strtotime($session->vote2)>$now)
                            <!-- 1er tour terminé, modifier le 2ème vote qui est encore en cours -->
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <div class="btn btn-primary">Vote en cours</div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end mb-3 row mb-3">
                                    <form class="" action="{{route('sessions.update', $session)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3 d-flex">
                                            <div>
                                                <h5>Candidat au 2ème tour :</h5>
                                                <input type="hidden" id="" name="role" value="{{$role->id}}" />
                                                @foreach ($win1 as $user)
                                                    @if ($user->role_id == $role->id and $user->registeredElection == 1)
                                                        <?php $total = $total + $user->result1; ?>
                                                    @endif
                                                @endforeach
                                                @foreach ($win1 as $user)
                                                    @if ($user->role_id == $role->id and $user->registeredElection == 1)
                                                        <div>
                                                            <p>{{$user->firstName}} {{$user->lastName}}
                                                                <b>
                                                                    <?php 
                                                                        $pourcentage = number_format($user->result1 / $total * 100, 0);
                                                                        if ( $pourcentage > 50) {
                                                                            $finish = true;
                                                                        }
                                                                        echo ($pourcentage.'%');
                                                                    ?>
                                                                </b>
                                                            </p> 
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="d-flex flex-column">
                                                <div>
                                                    <label for="vote2">Réinitialiser le temps avant la fin du 2ème tour : </label>
                                                    <input type="time" id="vote2" name="vote2" value="02:00" max="" />
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-warning">Modifier</button>
                                    </form>
                                </div> 
                                <?php $total = 0; ?>
                            @endif
                            @if ($role->id == $session->role_id and isset($session->vote1) and isset($session->vote2) and strtotime($session->vote2)<$now)
                            <!-- 2ème tour terminé, affichage du gagnant -->
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <div class="btn btn-primary">Terminé</div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end mb-3 row mb-3">
                                    <div class="mb-3 d-flex">
                                        <div>
                                            <h5>Élu : </h5>
                                        </div>
                                    </div>
                                </div> 
                            @endif
                                <?php $total = 0; ?>
                        @endforeach
                        @endif
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <div class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end mb-3 row mb-3">
                            <form class="" action="{{route('roles.update', $role)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="role" class="form-label">Groupe</label>
                                    <input type="text" class="form-control" id="role" name="role" placeholder="{{$role->role}}" value="{{$role->role}}">
                                </div>
                                <button type="submit" class="btn btn-primary">Modifier</button>
                            </form>
                        </div> 
                        @if (Auth::user()->role_id == 1)
                        <form action="{{ route('roles.destroy', $role) }}" method="POST">
                            @csrf
                            @method('delete')
                            
                            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                        @endif
                    </div>

                </div>
            @endif
            @endforeach
        </div>
    </div>
</div>
@endsection