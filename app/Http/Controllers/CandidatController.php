<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Candidat;
use App\Models\Comment;
use Illuminate\Http\Request;

class CandidatController extends Controller
{
    public function index($id_election)
    {
        $election = Election::findOrFail($id_election);
        $candidats = $election->candidats()->with('comments.utilisateur', 'comments.replies.utilisateur')->get();
        return view('candidats.index', compact('election', 'candidats'));
    }

    public function create($id_election)
    {
        if (auth()->user()->role !== 'ADMIN') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé : seuls les administrateurs peuvent créer des candidats.');
        }

        $election = Election::findOrFail($id_election);
        return view('candidats.create', compact('election'));
    }

    public function store(Request $request, $id_election)
    {
        if (auth()->user()->role !== 'ADMIN') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé : seuls les administrateurs peuvent créer des candidats.');
        }

        $request->validate([
            'nom' => 'required|string|max:100',
            'programme' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('candidats', 'public') : null;

        Candidat::create([
            'id_election' => $id_election,
            'nom' => $request->nom,
            'programme' => $request->programme,
            'image' => $imagePath,
        ]);

        return redirect()->route('candidats.index', $id_election)->with('success', 'Candidat ajouté avec succès !');
    }

    public function edit($id_election, $id_candidat)
    {
        if (auth()->user()->role !== 'ADMIN') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé : seuls les administrateurs peuvent modifier des candidats.');
        }
        $candidat = Candidat::findOrFail($id_candidat);
        $election = Election::findOrFail($id_election);
        return view('candidats.edit', compact('candidat', 'election'));
    }

    public function update(Request $request, $id_election, $id_candidat)
    {
        if (auth()->user()->role !== 'ADMIN') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé : seuls les administrateurs peuvent modifier des candidats.');
        }

        $request->validate([
            'nom' => 'required|string|max:100',
            'programme' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $candidat = Candidat::findOrFail($id_candidat);
        $imagePath = $request->file('image') ? $request->file('image')->store('candidats', 'public') : $candidat->image;

        $candidat->update([
            'nom' => $request->nom,
            'programme' => $request->programme,
            'image' => $imagePath,
        ]);

        return redirect()->route('candidats.index', $id_election)->with('success', 'Candidat mis à jour avec succès !');
    }

    public function destroy($id_election, $id_candidat)
    {
        if (auth()->user()->role !== 'ADMIN') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé : seuls les administrateurs peuvent supprimer des candidats.');
        }

        $candidat = Candidat::findOrFail($id_candidat);
        $candidat->delete();

        return redirect()->route('candidats.index', $id_election)->with('success', 'Candidat supprimé avec succès !');
    }

    public function comment(Request $request, $id_candidat)
    {
        $request->validate([
            'content' => 'required|string|max:500',
            'parent_id' => 'nullable|exists:comments,id_comment',
        ]);

        Comment::create([
            'id_utilisateur' => auth()->user()->id_utilisateur,
            'id_candidat' => $id_candidat,
            'content' => $request->content,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->back()->with('success', 'Commentaire ajouté avec succès !');
    }

    public function editComment($id_election, $id_candidat, $id_comment)
    {
        if (auth()->user()->role !== 'ADMIN') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé : seuls les administrateurs peuvent modifier des commentaires.');
        }
        $comment = Comment::findOrFail($id_comment);
        return view('comments.edit', compact('comment', 'id_election', 'id_candidat'));
    }

    public function updateComment(Request $request, $id_election, $id_candidat, $id_comment)
    {
        if (auth()->user()->role !== 'ADMIN') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé : seuls les administrateurs peuvent modifier des commentaires.');
        }

        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = Comment::findOrFail($id_comment);
        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('candidats.index', $id_election)->with('success', 'Commentaire mis à jour avec succès !');
    }

    public function destroyComment($id_election, $id_candidat, $id_comment)
    {
        if (auth()->user()->role !== 'ADMIN') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé : seuls les administrateurs peuvent supprimer des commentaires.');
        }

        $comment = Comment::findOrFail($id_comment);
        $comment->delete();

        return redirect()->route('candidats.index', $id_election)->with('success', 'Commentaire supprimé avec succès !');
    }
}
