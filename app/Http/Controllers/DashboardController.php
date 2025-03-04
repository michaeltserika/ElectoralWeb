<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Vote;
use App\Models\Notification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $elections = Election::all();
        $votes = Vote::where('id_utilisateur', $user->id_utilisateur)->get();
        $notifications = Notification::where('id_utilisateur', $user->id_utilisateur)->where('read', false)->get();

        // Séparer les élections ouvertes des élections clôturées
        $openElections = $elections->filter(function ($election) {
            return now()->lessThanOrEqualTo($election->date_fin);
        });

        $closedElections = $elections->filter(function ($election) {
            return now()->greaterThan($election->date_fin);
        });

        // Statistiques globales pour le graphique
        $totalVotes = Vote::count();
        $totalElections = Election::count();
        $votesByElection = Election::withCount('votes')->get()->pluck('votes_count', 'titre')->toArray();

        return view('dashboard', compact('user', 'openElections', 'closedElections', 'votes', 'notifications', 'totalVotes', 'totalElections', 'votesByElection'));
    }



    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        if ($notification->id_utilisateur === auth()->user()->id_utilisateur) {
            $notification->update(['read' => true]);
        }
        return redirect()->back();
    }
}
