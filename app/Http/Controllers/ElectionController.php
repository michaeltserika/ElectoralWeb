<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Utilisateur;
use App\Models\Notification;
use App\Models\Vote;
use Illuminate\Http\Request;
use PDF;

class ElectionController extends Controller
{
    public function index()
    {
        $elections = Election::all();
        return view('elections.index', compact('elections'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'ADMIN') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé : seuls les administrateurs peuvent créer des élections.');
        }
        return view('elections.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'ADMIN') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé : seuls les administrateurs peuvent créer des élections.');
        }

        $request->validate([
            'titre' => 'required|string|max:150',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'type' => 'required|in:etablissement,communal,administratif',
        ]);

        $election = Election::create($request->all());

        $users = Utilisateur::all();
        foreach ($users as $user) {
            Notification::create([
                'id_utilisateur' => $user->id_utilisateur,
                'message' => "Nouvelle élection : {$election->titre}",
            ]);
        }

        return redirect()->route('elections.index')->with('success', 'Élection créée avec succès !');
    }

    public function edit($id_election)
    {
        if (auth()->user()->role !== 'ADMIN') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé : seuls les administrateurs peuvent modifier des élections.');
        }
        $election = Election::findOrFail($id_election);
        return view('elections.edit', compact('election'));
    }

    public function update(Request $request, $id_election)
    {
        if (auth()->user()->role !== 'ADMIN') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé : seuls les administrateurs peuvent modifier des élections.');
        }

        $request->validate([
            'titre' => 'required|string|max:150',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'type' => 'required|in:etablissement,communal,administratif',
        ]);

        $election = Election::findOrFail($id_election);
        $election->update($request->all());

        return redirect()->route('elections.index')->with('success', 'Élection mise à jour avec succès !');
    }

    public function destroy($id_election)
    {
        if (auth()->user()->role !== 'ADMIN') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé : seuls les administrateurs peuvent supprimer des élections.');
        }

        $election = Election::findOrFail($id_election);
        $election->delete();

        return redirect()->route('elections.index')->with('success', 'Élection supprimée avec succès !');
    }

    public function search(Request $request)
    {
        $query = $request->query('query');
        $elections = Election::where('titre', 'LIKE', "%{$query}%")->get();
        return view('elections.index', compact('elections'));
    }

    public function results($id_election)
    {
        $election = Election::with('candidats.votes')->findOrFail($id_election);
        return view('elections.results', compact('election'));
    }

    public function exportVotesCsv($id_election)
    {
        $election = Election::findOrFail($id_election);
        $votes = Vote::where('id_election', $id_election)->with('utilisateur', 'candidat')->get();

        $filename = "votes_election_{$election->titre}.csv";
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['ID Vote', 'Utilisateur', 'Candidat', 'Date du vote']);

        foreach ($votes as $vote) {
            fputcsv($handle, [
                $vote->id_vote,
                $vote->utilisateur->nom,
                $vote->candidat->nom,
                $vote->date_vote
            ]);
        }

        fclose($handle);

        return response()->streamDownload(function () use ($handle) {}, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ]);
    }

    public function exportVotesPdf($id_election)
    {
        $election = Election::findOrFail($id_election);
        $votes = Vote::where('id_election', $id_election)->with('utilisateur', 'candidat')->get();

        $pdf = PDF::loadView('elections.votes_pdf', compact('election', 'votes'));
        return $pdf->download("votes_election_{$election->titre}.pdf");
    }
}
