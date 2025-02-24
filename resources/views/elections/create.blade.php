@extends('layouts.app')

@section('title', 'Créer une Élection')

@section('content')
    <div class="p-3 card">
        <h2 class="mb-3">Créer une Nouvelle Élection</h2>
        <form action="{{ route('elections.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="titre" class="form-label">Titre</label>
                <input id="titre" type="text" class="form-control @error('titre') is-invalid @enderror" name="titre" value="{{ old('titre') }}" required>
                @error('titre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="date_debut" class="form-label">Date de début</label>
                <input id="date_debut" type="date" class="form-control @error('date_debut') is-invalid @enderror" name="date_debut" value="{{ old('date_debut') }}" required>
                @error('date_debut')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="date_fin" class="form-label">Date de fin</label>
                <input id="date_fin" type="date" class="form-control @error('date_fin') is-invalid @enderror" name="date_fin" value="{{ old('date_fin') }}" required>
                @error('date_fin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type d’élection</label>
                <select id="type" class="form-select @error('type') is-invalid @enderror" name="type" required>
                    <option value="etablissement" {{ old('type') == 'etablissement' ? 'selected' : '' }}>Établissement</option>
                    <option value="communal" {{ old('type') == 'communal' ? 'selected' : '' }}>Communal</option>
                    <option value="administratif" {{ old('type') == 'administratif' ? 'selected' : '' }}>Administratif</option>
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Créer</button>
            <a href="{{ route('elections.index') }}" class="btn btn-outline-light ms-2">Annuler</a>
        </form>
    </div>
@endsection
