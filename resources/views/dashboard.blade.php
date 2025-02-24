@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
    <div class="p-3 mb-3 card">
        <div class="d-flex align-items-center">
            @if ($user->image)
                <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->nom }}" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
            @endif
            <div>
                <h2>{{ $user->nom }}</h2>
                <p class="text-muted">Rôle : {{ $user->role }}</p>
            </div>
        </div>
    </div>

    <div class="p-3 mb-3 card">
        <h4>Statistiques Globales</h4>
        <canvas id="statsChart" class="mb-4"></canvas>
        <p>Total des votes : {{ $totalVotes }}</p>
        <p>Total des élections : {{ $totalElections }}</p>
    </div>

    @if ($notifications->isNotEmpty())
        <div class="p-3 mb-3 card">
            <h4>Notifications</h4>
            <ul class="list-group">
                @foreach ($notifications as $notification)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $notification->message }}
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-light">Lu</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="p-3 mb-3 card">
        <h4>Vos votes</h4>
        @if ($votes->isEmpty())
            <p class="text-muted">Vous n'avez pas encore voté.</p>
        @else
            <ul class="list-group">
                @foreach ($votes as $vote)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $vote->election->titre }} - {{ $vote->candidat->nom }}</span>
                        <small class="text-muted">{{ $vote->date_vote }}</small>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="p-3 card">
        <h4>Élections disponibles</h4>
        <ul class="list-group">
            @foreach ($elections as $election)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $election->titre }} <small class="text-muted">({{ $election->date_debut }} - {{ $election->date_fin }})</small>
                    <div>
                        <a href="{{ route('elections.results', $election->id_election) }}" class="btn btn-outline-light btn-sm me-2">Résultats</a>
                        <a href="{{ route('votes.create', $election->id_election) }}" class="btn btn-primary btn-sm">Voter</a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <script>
        const ctx = document.getElementById('statsChart').getContext('2d');
        const statsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($votesByElection)) !!},
                datasets: [{
                    label: 'Votes par élection',
                    data: {!! json_encode(array_values($votesByElection)) !!},
                    backgroundColor: '#1d9bf0',
                    borderColor: '#1d9bf0',
                    borderWidth: 1
                }]
            },
            options: {
                scales: { y: { beginAtZero: true } },
                plugins: { legend: { display: true } }
            }
        });
    </script>
@endsection
