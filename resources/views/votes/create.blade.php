@extends('layouts.app')

@section('title', 'Voter - ' . $election->titre)

@section('content')
    <div class="p-3 card">
        <h2 class="mb-3">Voter pour {{ $election->titre }}</h2>
        <form action="{{ route('votes.store', $election->id_election) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="id_candidat" class="form-label">Choisir un candidat</label>
                <select id="id_candidat" class="form-select @error('id_candidat') is-invalid @enderror" name="id_candidat" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach ($election->candidats as $candidat)
                        <option value="{{ $candidat->id_candidat }}">{{ $candidat->nom }}</option>
                    @endforeach
                </select>
                @error('id_candidat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Voter</button>
            <a href="{{ route('elections.index') }}" class="btn btn-outline-light ms-2">Annuler</a>
        </form>
    </div>
@endsection
