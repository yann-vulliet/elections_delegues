@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
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
        </div>
    </div>
</div>
@endsection
