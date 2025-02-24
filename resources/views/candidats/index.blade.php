@extends('layouts.app')

@section('title', 'Candidats - ' . $election->titre)

@section('content')
    <div class="p-3 card">
        <h2 class="mb-3" style="color: {{ session('theme', 'dark') == 'dark' ? '#e7e9ea' : '#0f1419' }}">{{ $election->titre }}</h2>
        @if (auth()->user()->role === 'ADMIN')
            <a href="{{ route('candidats.create', $election->id_election) }}" class="mb-3 btn btn-primary" title="Ajouter un candidat">
                <i class="bi bi-person-plus"></i>
            </a>
        @endif
        @if ($candidats->isEmpty())
            <p class="text-muted" style="color: {{ session('theme', 'dark') == 'dark' ? '#8899a6' : '#657786' }}">Aucun candidat pour cette élection.</p>
        @else
            @foreach ($candidats as $candidat)
                <div class="p-3 mb-3 card">
                    <div class="d-flex align-items-center">
                        @if ($candidat->image)
                            <img src="{{ asset('storage/' . $candidat->image) }}" alt="{{ $candidat->nom }}" class="rounded-circle profile-img me-3" style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/50" alt="{{ $candidat->nom }}" class="rounded-circle profile-img me-3" style="width: 50px; height: 50px; object-fit: cover;">
                        @endif
                        <div class="flex-grow-1">
                            <h4 class="mb-1" style="color: {{ session('theme', 'dark') == 'dark' ? '#e7e9ea' : '#0f1419' }}">{{ $candidat->nom }}</h4>
                            <p class="mb-0 text-muted" style="color: {{ session('theme', 'dark') == 'dark' ? '#8899a6' : '#657786' }}">{{ $candidat->programme ?? 'Aucun programme défini' }}</p>
                        </div>
                        @if (auth()->user()->role === 'ADMIN')
                            <div class="d-flex align-items-center">
                                <a href="{{ route('candidats.edit', [$election->id_election, $candidat->id_candidat]) }}" class="btn btn-sm btn-outline-light me-2" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('candidats.destroy', [$election->id_election, $candidat->id_candidat]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce candidat ?');">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                    <div class="mt-3">
                        <h5 class="mb-2" style="color: {{ session('theme', 'dark') == 'dark' ? '#e7e9ea' : '#0f1419' }}">Commentaires</h5>
                        @if ($candidat->comments->isEmpty())
                            <p class="text-muted" style="color: {{ session('theme', 'dark') == 'dark' ? '#8899a6' : '#657786' }}">Aucun commentaire pour ce candidat.</p>
                        @else
                            @foreach ($candidat->comments as $comment)
                                <div class="p-2 mb-2 card" style="background-color: {{ session('theme', 'dark') == 'dark' ? '#192734' : '#f9f9f9' }};">
                                    <div class="d-flex align-items-start">
                                        <img src="{{ $comment->utilisateur->image ? asset('storage/' . $comment->utilisateur->image) : 'https://via.placeholder.com/30' }}" alt="{{ $comment->utilisateur->nom }}" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong style="color: {{ session('theme', 'dark') == 'dark' ? '#e7e9ea' : '#0f1419' }}">{{ $comment->utilisateur->nom }}</strong>
                                                    <small class="text-muted ms-2" style="color: {{ session('theme', 'dark') == 'dark' ? '#8899a6' : '#657786' }}">{{ $comment->created_at->diffForHumans() }}</small>
                                                </div>
                                                @if (auth()->user()->role === 'ADMIN')
                                                    <div>
                                                        <a href="{{ route('candidats.comment.edit', [$election->id_election, $candidat->id_candidat, $comment->id_comment]) }}" class="btn btn-sm btn-outline-light me-2" title="Modifier commentaire">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <form action="{{ route('candidats.comment.destroy', [$election->id_election, $candidat->id_candidat, $comment->id_comment]) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer commentaire" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                            <p class="mb-0" style="color: {{ session('theme', 'dark') == 'dark' ? '#d1d9e0' : '#0f1419' }}">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                    @foreach ($comment->replies as $reply)
                                        <div class="p-2 mt-2 card ms-4" style="background-color: {{ session('theme', 'dark') == 'dark' ? '#253341' : '#f0f0f0' }};">
                                            <div class="d-flex align-items-start">
                                                <img src="{{ $reply->utilisateur->image ? asset('storage/' . $reply->utilisateur->image) : 'https://via.placeholder.com/30' }}" alt="{{ $reply->utilisateur->nom }}" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong style="color: {{ session('theme', 'dark') == 'dark' ? '#e7e9ea' : '#0f1419' }}">{{ $reply->utilisateur->nom }}</strong>
                                                            <small class="text-muted ms-2" style="color: {{ session('theme', 'dark') == 'dark' ? '#8899a6' : '#657786' }}">{{ $reply->created_at->diffForHumans() }}</small>
                                                        </div>
                                                        @if (auth()->user()->role === 'ADMIN')
                                                            <div>
                                                                <a href="{{ route('candidats.comment.edit', [$election->id_election, $candidat->id_candidat, $reply->id_comment]) }}" class="btn btn-sm btn-outline-light me-2" title="Modifier réponse">
                                                                    <i class="bi bi-pencil"></i>
                                                                </a>
                                                                <form action="{{ route('candidats.comment.destroy', [$election->id_election, $candidat->id_candidat, $reply->id_comment]) }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer réponse" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réponse ?');">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <p class="mb-0" style="color: {{ session('theme', 'dark') == 'dark' ? '#d1d9e0' : '#0f1419' }}">{{ $reply->content }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <form action="{{ route('candidats.comment', [$election->id_election, $candidat->id_candidat]) }}" method="POST" class="mt-2">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $comment->id_comment }}">
                                        <div class="input-group">
                                            <input type="text" name="content" class="form-control" placeholder="Répondre..." required>
                                            <button type="submit" class="btn btn-primary" title="Répondre">
                                                <i class="bi bi-reply-fill"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        @endif
                        <form action="{{ route('candidats.comment', [$election->id_election, $candidat->id_candidat]) }}" method="POST" class="mt-3">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="content" class="form-control" placeholder="Ajouter un commentaire..." required>
                                <button type="submit" class="btn btn-primary" title="Commenter">
                                    <i class="bi bi-chat-left-text"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
            <a href="{{ route('elections.index') }}" class="mt-3 btn btn-outline-light" title="Retour">
                <i class="bi bi-arrow-left"></i>
            </a>
        @endif
    </div>
@endsection
