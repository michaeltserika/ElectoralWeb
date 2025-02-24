<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Vote;
use App\Models\Utilisateur;
use App\Models\Candidat;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function create($id_election)
    {
        $election = Election::with('candidats')->findOrFail($id_election);

        // Vérifier si l’élection est clôturée
        if ($election->isClosed()) {
            return redirect()->route('elections.index')->with('error', 'Cette élection est clôturée, vous ne pouvez plus voter.');
        }

        // Vérifier si l'utilisateur a déjà voté
        $hasVoted = Vote::where('id_utilisateur', auth()->user()->id_utilisateur)
            ->where('id_election', $id_election)
            ->exists();
        if ($hasVoted) {
            return redirect()->route('elections.index')->with('error', 'Vous avez déjà voté pour cette élection.');
        }

        // Vérifier les conditions selon le type d’élection
        $user = auth()->user();
        if ($election->type === 'etablissement') {
            if (!$user->ce_number) {
                return redirect()->route('elections.index')->with('error', 'Vous devez fournir un numéro CE pour voter dans une élection d’établissement.');
            }
        } elseif (in_array($election->type, ['communal', 'administratif'])) {
            if (!$user->cin_number && !$user->ce_number) {
                return redirect()->route('elections.index')->with('error', 'Vous devez fournir un CIN ou un CE pour voter dans une élection communale ou administrative.');
            }
            if ($user->age < 18) {
                return redirect()->route('elections.index')->with('error', 'Vous devez avoir 18 ans ou plus pour voter dans une élection communale ou administrative.');
            }
        }

        return view('votes.create', compact('election'));
    }


    public function edit($id_election, $id_vote)
    {
        if (auth()->user()->role !== 'ADMIN') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé : seuls les administrateurs peuvent modifier des votes.');
        }
        $vote = Vote::findOrFail($id_vote);
        $election = Election::findOrFail($id_election);
        $candidats = $election->candidats;
        return view('votes.edit', compact('vote', 'election', 'candidats'));
    }

    public function update(Request $request, $id_election, $id_vote)
    {
        if (auth()->user()->role !== 'ADMIN') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé : seuls les administrateurs peuvent modifier des votes.');
        }

        $request->validate([
            'id_candidat' => 'required|exists:candidats,id_candidat',
        ]);

        $vote = Vote::findOrFail($id_vote);
        $vote->update([
            'id_candidat' => $request->id_candidat,
        ]);

        return redirect()->route('elections.results', $id_election)->with('success', 'Vote mis à jour avec succès !');
    }

    public function destroy($id_election, $id_vote)
    {
        if (auth()->user()->role !== 'ADMIN') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé : seuls les administrateurs peuvent supprimer des votes.');
        }

        $vote = Vote::findOrFail($id_vote);
        $vote->delete();

        return redirect()->route('elections.results', $id_election)->with('success', 'Vote supprimé avec succès !');
    }
    public function store(Request $request, $id_election)
    {
        $election = Election::findOrFail($id_election);

        // Vérifier si l’élection est clôturée
        if ($election->isClosed()) {
            return redirect()->route('elections.index')->with('error', 'Cette élection est clôturée, vous ne pouvez plus voter.');
        }

        $request->validate([
            'id_candidat' => 'required|exists:candidats,id_candidat',
        ]);

        $id_utilisateur = auth()->user()->id_utilisateur;

        // Vérifier si l’utilisateur a déjà voté
        $hasVoted = Vote::where('id_utilisateur', $id_utilisateur)
            ->where('id_election', $id_election)
            ->exists();
        if ($hasVoted) {
            return redirect()->route('elections.index')->with('error', 'Vous avez déjà voté pour cette élection.');
        }

        // Vérifier les conditions selon le type d’élection
        $user = auth()->user();
        if ($election->type === 'etablissement') {
            if (!$user->ce_number) {
                return redirect()->route('elections.index')->with('error', 'Vous devez fournir un numéro CE pour voter dans une élection d’établissement.');
            }
        } elseif (in_array($election->type, ['communal', 'administratif'])) {
            if (!$user->cin_number && !$user->ce_number) {
                return redirect()->route('elections.index')->with('error', 'Vous devez fournir un CIN ou un CE pour voter dans une élection communale ou administrative.');
            }
            if ($user->age < 18) {
                return redirect()->route('elections.index')->with('error', 'Vous devez avoir 18 ans ou plus pour voter dans une élection communale ou administrative.');
            }
        }

        Vote::create([
            'id_utilisateur' => $id_utilisateur,
            'id_election' => $id_election,
            'id_candidat' => $request->id_candidat,
        ]);

        return redirect()->route('elections.index')->with('success', 'Vote enregistré avec succès !');
    }

    // Méthodes pour importation CSV (inchangées)
    public function import($id_election)
    {
        $election = Election::findOrFail($id_election);
        return view('votes.import', compact('election'));
    }

    public function importCsv(Request $request, $id_election)
    {
        if (auth()->user()->role !== 'ADMIN') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé : seuls les administrateurs peuvent importer des votes.');
        }

        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data);

        if ($header !== ['id_utilisateur', 'id_candidat', 'date_vote']) {
            return redirect()->back()->with('error', 'Le fichier CSV doit avoir les colonnes : id_utilisateur, id_candidat, date_vote');
        }

        foreach ($data as $row) {
            $id_utilisateur = $row[0];
            $id_candidat = $row[1];
            $date_vote = $row[2];

            if (!Utilisateur::find($id_utilisateur) || !Candidat::find($id_candidat)) {
                continue;
            }

            $hasVoted = Vote::where('id_utilisateur', $id_utilisateur)
                ->where('id_election', $id_election)
                ->exists();
            if (!$hasVoted) {
                Vote::create([
                    'id_utilisateur' => $id_utilisateur,
                    'id_election' => $id_election,
                    'id_candidat' => $id_candidat,
                    'date_vote' => $date_vote
                ]);
            }
        }

        return redirect()->route('elections.results', $id_election)->with('success', 'Votes importés avec succès !');
    }
}
