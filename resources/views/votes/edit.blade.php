@extends('layouts.app')

@section('title', 'Modifier Vote')

@section('content')
    <div class="p-3 card">
        <h2 class="mb-3">Modifier Vote pour {{ $election->titre }}</h2>
        <form action="{{ route('votes.update', [$election->id_election, $vote->id_vote]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="id_candidat" class="form-label">Candidat</label>
                <select id="id_candidat" class="form-select @error('id_candidat') is-invalid @enderror" name="id_candidat" required>
                    @foreach ($candidats as $candidat)
                        <option value="{{ $candidat->id_candidat }}" {{ $candidat->id_candidat == $vote->id_candidat ? 'selected' : '' }}>{{ $candidat->nom }}</option>
                    @endforeach
                </select>
                @error('id_candidat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('elections.results', $election->id_election) }}" class="btn btn-outline-light ms-2">Annuler</a>
        </form>
    </div>
@endsection
