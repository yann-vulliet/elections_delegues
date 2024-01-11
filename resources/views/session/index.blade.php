@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>test</h2>
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <div class="btn btn-primary">Nouveau vote</div>
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
            @foreach ($sessions as $session)
                <hr>
                <div class="d-flex flex-row flex-wrap">
                    <div class="d-flex flex-column left">
                        <h5>{{ $session->role->role }}</h5>
                    </div>
                    
                    <div class="btn-admin right">
                        <a class="btn btn-primary" href="{{ route('sessions.show', $session) }}"><i class="fa-solid fa-eye"></i></a>
                        
                        @if (Auth::user()->role_id <= 2)
                        <form action="{{ route('sessions.destroy', $session) }}" method="POST">
                            @csrf
                            @method('delete')
                            
                            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection