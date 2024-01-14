@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Identification effectuée') }}
                </div>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <div class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end mb-3 row mb-3">
                            <form class="" action="{{route('users.update', $user)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="firstName" class="form-label">Prénom</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="{{$user->firstName}}" value="{{$user->firstName}}">
                                </div>
                                <div class="mb-3">
                                    <label for="lastName" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName" placeholder="{{$user->lastName}}" value="{{$user->lastName}}">
                                </div>
                                <div class="mb-3">
                                    <label for="discord" class="form-label">Discord</label>
                                    <input type="text" class="form-control" id="discord" name="discord" placeholder="{{$user->discord}}" value="{{$user->discord}}">
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Adresse</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="{{$user->address}}" value="{{$user->address}}">
                                </div>
                                <div class="mb-3">
                                    <label for="zipCode" class="form-label">Code postal</label>
                                    <input type="text" pattern="[0-9]{5}" maxlength="5" class="form-control" id="zipCode" name="zipCode" placeholder="{{$user->zipCode}}" value="{{$user->zipCode}}">
                                </div>
                                <div class="mb-3">
                                    <label for="city" class="form-label">Ville</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="{{$user->city}}" value="{{$user->city}}">
                                </div>
                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="avatar" name="avatar" placeholder="{{$user->avatar}}" value="{{$user->avatar}}">
                                </div>
                                <button type="submit" class="btn btn-primary">Modifier</button>
                            </form>
                        </div>
                    </li>
                </ul>

                <div class="">
                    <div class="center">
                        <div class="img-container">
                            @if ($user->avatar == 'no-avatar.png')
                            <img src="/image/{{ $user->avatar }}" alt="{{ $user->avatar }}">
                            @else
                            <img src="/storage/image/{{ $user->avatar }}" alt="{{ $user->avatar }}">
                            @endif
                        </div>
                        <h5>{{ $user->firstName }} {{ $user->lastName }}</h5>
                        <h5>{{ $user->address }}</h5>
                        <h5>{{ $user->zipCode }} {{ $user->city }}</h5>
                        <h5>{{ $user->discord }}</h5>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="">
                    @foreach ($sessions as $session)
                        @if (!$sessions->contains('role_id', Auth::user()->role_id)) <!-- Jamais eu de vote pour la session -->
                        @elseif ($session->role_id == $user->role_id and $session->vote1>now() and !isset($session->vote2) and !isset($user->vote1)) <!-- Vote pour le 1er tour -->
                            <h2>{{$user->role->role}}</h2>
                            <div class="center">
                                <div>
                                    <form class="" action="{{route('users.update', $user)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                        <div class="mb-3 d-flex">
                                            <div class="center">
                                                        <hr>
                                                        <div class="d-flex justify-content-between">
                                                            <input type="radio" id="{{$user->id}}" name="vote1" value="" />
                                                            <label for="{{$user->id}}">Blanc</label>
                                                        </div>
                                                        <hr>
                                                @foreach ($users as $user)
                                                    @if ($user->registeredElection == 1)
                                                        <hr>
                                                        <div class="d-flex justify-content-between">
                                                            <input type="radio" id="{{$user->id}}" name="vote1" value="{{$user->id}}" />
                                                            <label for="{{$user->id}}">{{$user->firstName}} {{$user->lastName}}</label>
                                                        </div>
                                                        <hr>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Valider mon vote</button>
                                    </form>
                                </div>
                            </div>
                        @elseif ($session->role_id == $user->role_id and $session->vote1>now() and !isset($session->vote2) and isset($user->vote1)) <!-- Fin du 1er tour pour l'utilisateur -->
                            <h2>{{$user->role->role}}</h2>
                            <div class="center">
                                <div>
                                    <div class="mb-3 d-flex">
                                        <div class="center">
                                            En attente du retour administrateur pour la suite de l'élection
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif ($session->role_id == $user->role_id and $session->vote2>now() and !isset($user->vote2)) <!-- Vote pour le 2ème tour -->
                            <h2>{{$user->role->role}}</h2>
                            <div class="center">
                                <div>
                                    <form class="" action="{{route('users.update', $user)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                        <div class="mb-3 d-flex">
                                            <div class="center">
                                                        <hr>
                                                        <div class="d-flex justify-content-between">
                                                            <input type="radio" id="0" name="vote2" value="" />
                                                            <label for="0">Blanc</label>
                                                        </div>
                                                        <hr>
                                                @foreach ($win1 as $user)
                                                    @if ($user->registeredElection == 1)
                                                        <hr>
                                                        <div class="d-flex justify-content-between">
                                                            <input type="radio" id="{{$user->id}}" name="vote2" value="{{$user->id}}" />
                                                            <label for="{{$user->id}}">{{$user->firstName}}{{$user->lastName}}</label>
                                                        </div>
                                                        <hr>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Valider mon vote</button>
                                    </form>
                                </div>
                            </div>
                        @elseif ($session->role_id == $user->role_id and $session->vote1<now() and $session->vote2>now() and isset($session->vote2)) <!-- Fin du 2ème tour pour l'utilisateur -->
                            <h2>{{$user->role->role}}</h2>
                            <div class="center">
                                <div>
                                    <div class="mb-3 d-flex">
                                        <div class="center">
                                            En attente du retour administrateur pour la suite de l'élection
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif ($session->role_id == $user->role_id and $session->vote2<now()) <!-- Résultat du 2ème tour -->
                            <h2>{{$user->role->role}}</h2>
                            <div class="center">
                                <div>
                                <div class="mb-3 d-flex">
                                    <div>
                                        <h5>Élu : <b> {{$win2->firstName}} {{$win2->LastName}}</b></h5>
                                        <h6>Suppléant : <b> {{$win2_2->firstName}} {{$win2_2->LastName}}</b></h5>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
