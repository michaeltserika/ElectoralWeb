@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <div class="p-3 card">
        <h2 class="mb-4 text-center"><i class="bi bi-box-arrow-in-right"></i> Connexion</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                <label class="form-check-label" for="remember">Se souvenir de moi</label>
            </div>
            <div class="gap-2 d-grid">
                <button type="submit" class="btn btn-primary">Se connecter</button>
                <a href="{{ route('register') }}" class="btn btn-outline-light">S'inscrire</a>
            </div>
        </form>
    </div>
@endsection
