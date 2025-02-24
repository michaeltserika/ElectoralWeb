@extends('layouts.app')

@section('title', 'Modifier Commentaire')

@section('content')
    <div class="p-3 card">
        <h2 class="mb-3">Modifier Commentaire</h2>
        <form action="{{ route('candidats.comment.update', [$id_election, $id_candidat, $comment->id_comment]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="content" class="form-label">Contenu</label>
                <textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content" rows="3" required>{{ old('content', $comment->content) }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('candidats.index', $id_election) }}" class="btn btn-outline-light ms-2">Annuler</a>
        </form>
    </div>
@endsection