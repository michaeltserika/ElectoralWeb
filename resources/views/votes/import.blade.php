@extends('layouts.app')

@section('title', 'Importer des Votes')

@section('content')
    <div class="p-3 card">
        <h2 class="mb-3">Importer des votes pour {{ $election->titre }}</h2>
        <form action="{{ route('votes.import.csv', $election->id_election) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="csv_file" class="form-label">Fichier CSV (format : id_utilisateur, id_candidat, date_vote)</label>
                <input id="csv_file" type="file" class="form-control @error('csv_file') is-invalid @enderror" name="csv_file" accept=".csv" required>
                @error('csv_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Importer</button>
            <a href="{{ route('elections.index') }}" class="btn btn-outline-light ms-2">Annuler</a>
        </form>
    </div>
@endsection