@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>{{ $session->role->role }}</h2>           
            <div class="card">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <div class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end mb-3 row mb-3">
                            <form class="" action="{{route('sessions.update', $session)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="firstName" class="form-label">Prénom</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="{{$session->session}}" value="{{$session->session}}">
                                </div>
                                <button type="submit" class="btn btn-primary">Modifier</button>
                            </form>
                        </div>
                    </li>
                </ul>

                <div class="">
                    <div class="center">
                        <h5></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
