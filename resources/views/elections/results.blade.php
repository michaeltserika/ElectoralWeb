@extends('layouts.app')

@section('title', 'Résultats - ' . $election->titre)

@section('content')
    <div class="p-3 card">
        <h2 class="mb-3">{{ $election->titre }}</h2>
        <p class="mb-4 text-muted">{{ $election->date_debut }} - {{ $election->date_fin }}</p>
        <div class="mb-3">
            <a href="{{ route('elections.export.votes.csv', $election->id_election) }}" class="btn btn-primary me-2">Exporter en CSV</a>
            <a href="{{ route('elections.export.votes.csv', $election->id_election) }}" class="btn btn-primary me-2">Exporter en CSV</a>
             <a href="{{ route('elections.export.votes.pdf', $election->id_election) }}" class="btn btn-primary me-2">Exporter en PDF</a>
             <a href="{{ route('votes.import', $election->id_election) }}" class="btn btn-primary">Importer des votes</a>
            <a href="{{ route('elections.export.votes.pdf', $election->id_election) }}" class="btn btn-primary">Exporter en PDF</a>
        </div>
        <canvas id="resultsChart" class="mb-4"></canvas>
        @foreach ($election->candidats as $candidat)
            <div class="p-3 mb-2 list-group-item d-flex align-items-center">
                @if ($candidat->image)
                    <img src="{{ asset('storage/' . $candidat->image) }}" alt="{{ $candidat->nom }}" class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                @endif
                <div class="flex-grow-1">
                    <strong>{{ $candidat->nom }}</strong>
                    <small class="text-muted d-block">{{ $candidat->votes->count() }} votes</small>
                </div>
            </div>
        @endforeach
        <a href="{{ route('elections.index') }}" class="mt-3 btn btn-outline-light">Retour</a>
    </div>

    <script>
        const ctx = document.getElementById('resultsChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [@foreach ($election->candidats as $candidat)'{{ $candidat->nom }}', @endforeach],
                datasets: [{
                    label: 'Nombre de votes',
                    data: [@foreach ($election->candidats as $candidat){{ $candidat->votes->count() }}, @endforeach],
                    backgroundColor: '#1d9bf0',
                    borderColor: '#1d9bf0',
                    borderWidth: 1
                }]
            },
            options: {
                scales: { y: { beginAtZero: true } },
                plugins: { legend: { display: false } }
            }
        });
    </script>
@endsection
