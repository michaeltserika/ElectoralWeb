@extends('layouts.app')

@section('title', 'Ajouter un Candidat')

@section('content')
    <div class="p-3 card">
        <h2 class="mb-3">Ajouter un candidat pour {{ $election->titre }}</h2>
        <form action="{{ route('candidats.store', $election->id_election) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required>
                @error('nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="programme" class="form-label">Programme</label>
                <textarea id="programme" class="form-control @error('programme') is-invalid @enderror" name="programme" rows="3">{{ old('programme') }}</textarea>
                @error('programme')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Photo</label>
                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
            <a href="{{ route('candidats.index', $election->id_election) }}" class="btn btn-outline-light ms-2">Annuler</a>
        </form>
    </div>
@endsection
