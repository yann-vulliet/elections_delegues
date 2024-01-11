@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>test</h2>
            @foreach ($users as $user)
            @if ($user->role_id == null)
                <hr>
                <div class="d-flex flex-row flex-wrap">
                    <div class="d-flex flex-column left">
                        <h5>{{ $user->firstName }} {{ $user->lastName }}</h5>
                            <p>{{ $user->email }}</p>
                            <a id="navbarDropdown" class="nav-link dropdown-toggle max-content" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @if ($user->role)
                                    <div class="btn btn-light">{{ $user->role->role }}</div>
                                @else
                                    <div class="btn btn-primary">Choisir un role</div>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-start mb-1 row mb-1">
                                <form class="" action="{{route('users.update', $user)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <select name="role_id" id="">
                                            @foreach ($roles as $role)
                                                <option value="{{$role->id}}" @if($user->role_id == $role->id) selected @endif>{{$role->role}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Modifier</button>
                                </form>
                            </div>
                    </div>
                    
                    <div class="btn-admin right">
                        <a class="btn btn-primary" href="{{ route('users.show', $user) }}"><i class="fa-solid fa-eye"></i></a>
                        
                        @if (Auth::user()->role_id == 1)
                        <form action="{{ route('users.destroy', $user) }}" method="POST">
                            @csrf
                            @method('delete')
                            
                            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                        @endif
                    </div>
                </div>
            @endif
            @endforeach
            @foreach ($users as $user)
            @if ($user->role_id != null)
                <hr>
                <div class="d-flex flex-row flex-wrap">
                    <div class="d-flex flex-column left">
                        <h5>{{ $user->firstName }} {{ $user->lastName }}</h5>
                            <p>{{ $user->email }}</p>
                            <a id="navbarDropdown" class="nav-link dropdown-toggle max-content" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @if ($user->role)
                                    <div class="btn btn-light">{{ $user->role->role }}</div>
                                @else
                                    <div class="btn btn-primary">Choisir un role</div>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-start mb-1 row mb-1">
                                <form class="" action="{{route('users.update', $user)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <select name="role_id" id="">
                                            @foreach ($roles as $role)
                                                <option value="{{$role->id}}" @if($user->role_id == $role->id) selected @endif>{{$role->role}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Modifier</button>
                                </form>
                            </div>
                    </div>
                    
                    <div class="btn-admin right">
                        <a class="btn btn-primary" href="{{ route('users.show', $user) }}"><i class="fa-solid fa-eye"></i></a>
                        
                        @if (Auth::user()->role_id == 1)
                        <form action="{{ route('users.destroy', $user) }}" method="POST">
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