@extends('layouts.app')

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
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <div class="btn btn-primary">Créer un vote</div>
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