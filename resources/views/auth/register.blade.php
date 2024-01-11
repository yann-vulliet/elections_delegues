@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Création de votre compte</h2>

    <div class="card-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="row mb-3">
                <label for="firstName" class="col-md-3 col-form-label text-md-end">{{ __('Prénom') }}</label>

                <div class="col-md-3">
                    <input id="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ old('firstName') }}" required autofocus>

                    @error('firstName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="lastName" class="col-md-3 col-form-label text-md-end">{{ __('Nom') }}</label>

                <div class="col-md-3">
                    <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ old('lastName') }}" required autofocus>

                    @error('lastName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="address" class="col-md-3 col-form-label text-md-end">{{ __('Adresse') }}</label>

                <div class="col-md-3">
                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autofocus>

                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="zipCode" class="col-md-3 col-form-label text-md-end">{{ __('Code Postal') }}</label>

                <div class="col-md-3">
                    <input id="zipCode" type="text" pattern="[0-9]{5}" maxlength="5" class="form-control @error('zipCode') is-invalid @enderror" name="zipCode" value="{{ old('zipCode') }}" required autofocus>

                    @error('zipCode')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="city" class="col-md-3 col-form-label text-md-end">{{ __('Ville') }}</label>

                <div class="col-md-3">
                    <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autofocus>

                    @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="email" class="col-md-3 col-form-label text-md-end">{{ __('Adresse mail') }}</label>

                <div class="col-md-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password" class="col-md-3 col-form-label text-md-end">{{ __('Mot de Passe') }}</label>

                <div class="col-md-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password-confirm" class="col-md-3 col-form-label text-md-end">{{ __('Confirmer le Mot de Passe') }}</label>

                <div class="col-md-3">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-3 offset-md-3 text-md-end">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Valider') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
