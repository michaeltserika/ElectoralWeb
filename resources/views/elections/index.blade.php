@extends('layouts.app')

@section('title', 'Liste des Élections')

@section('content')
    <div class="p-3 card">
        <h2 class="mb-3">Élections</h2>
        @if (auth()->user()->role === 'ADMIN')
            <a href="{{ route('elections.create') }}" class="mb-3 btn btn-primary">Ajouter une élection</a>
        @endif
        @if ($elections->isEmpty())
            <p class="text-muted">Aucune élection disponible.</p>
        @else
            <ul class="list-group">
                @foreach ($elections as $election)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $election->titre }} <small class="text-muted">({{ $election->date_debut }} - {{ $election->date_fin }}) - {{ ucfirst($election->type) }}</small>
                        <div>
                            <a href="{{ route('candidats.index', $election->id_election) }}" class="btn btn-outline-light btn-sm me-2">Candidats</a>
                            <a href="{{ route('elections.results', $election->id_election) }}" class="btn btn-outline-light btn-sm me-2">Résultats</a>
                            <a href="{{ route('votes.create', $election->id_election) }}" class="btn btn-primary btn-sm me-2">Voter</a>
                            @if (auth()->user()->role === 'ADMIN')
                                <a href="{{ route('elections.edit', $election->id_election) }}" class="btn btn-outline-light btn-sm me-2">Modifier</a>
                                <form action="{{ route('elections.destroy', $election->id_election) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette élection ?');">Supprimer</button>
                                </form>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
