@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <div class="p-3 card">
        <h2 class="mb-4 text-center"><i class="bi bi-person-plus"></i> Inscription</h2>
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required>
                @error('nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
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
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>
            <div class="mb-3">
                <label for="ce_number" class="form-label">Numéro CE (Carte d’Étudiant)</label>
                <input id="ce_number" type="text" class="form-control @error('ce_number') is-invalid @enderror" name="ce_number" value="{{ old('ce_number') }}">
                @error('ce_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="cin_number" class="form-label">Numéro CIN (Carte d’Identité Nationale)</label>
                <input id="cin_number" type="text" class="form-control @error('cin_number') is-invalid @enderror" name="cin_number" value="{{ old('cin_number') }}">
                @error('cin_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Date de naissance</label>
                <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                @error('date_of_birth')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Photo de profil</label>
                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="gap-2 d-grid">
                <button type="submit" class="btn btn-primary">S'inscrire</button>
                <a href="{{ route('login') }}" class="btn btn-outline-light">Se connecter</a>
            </div>
        </form>
    </div>
@endsection
