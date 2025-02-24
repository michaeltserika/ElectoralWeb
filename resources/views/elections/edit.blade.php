@extends('layouts.app')

@section('title', 'Modifier Élection')

@section('content')
    <div class="p-3 card">
        <h2 class="mb-3">Modifier {{ $election->titre }}</h2>
        <form action="{{ route('elections.update', $election->id_election) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="titre" class="form-label">Titre</label>
                <input id="titre" type="text" class="form-control @error('titre') is-invalid @enderror" name="titre" value="{{ old('titre', $election->titre) }}" required>
                @error('titre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="date_debut" class="form-label">Date de début</label>
                <input id="date_debut" type="date" class="form-control @error('date_debut') is-invalid @enderror" name="date_debut" value="{{ old('date_debut', $election->date_debut) }}" required>
                @error('date_debut')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="date_fin" class="form-label">Date de fin</label>
                <input id="date_fin" type="date" class="form-control @error('date_fin') is-invalid @enderror" name="date_fin" value="{{ old('date_fin', $election->date_fin) }}" required>
                @error('date_fin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type d’élection</label>
                <select id="type" class="form-select @error('type') is-invalid @enderror" name="type" required>
                    <option value="etablissement" {{ old('type', $election->type) == 'etablissement' ? 'selected' : '' }}>Établissement</option>
                    <option value="communal" {{ old('type', $election->type) == 'communal' ? 'selected' : '' }}>Communal</option>
                    <option value="administratif" {{ old('type', $election->type) == 'administratif' ? 'selected' : '' }}>Administratif</option>
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('elections.index') }}" class="btn btn-outline-light ms-2">Annuler</a>
        </form>
    </div>
@endsection