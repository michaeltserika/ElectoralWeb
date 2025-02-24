<?php

use App\Http\Controllers\ElectionController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

// Route publique pour la page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route publique pour basculer le thème
Route::post('/toggle-theme', [ThemeController::class, 'toggle'])->name('toggle.theme');

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/notifications/{id}/read', [DashboardController::class, 'markAsRead'])->name('notifications.read');

    // Routes pour les élections
    Route::get('/elections', [ElectionController::class, 'index'])->name('elections.index');
    Route::get('/elections/search', [ElectionController::class, 'search'])->name('elections.search');
    Route::get('/elections/{id_election}/results', [ElectionController::class, 'results'])->name('elections.results');
    Route::get('/elections/create', [ElectionController::class, 'create'])->name('elections.create');
    Route::post('/elections', [ElectionController::class, 'store'])->name('elections.store');
    Route::get('/elections/{id_election}/edit', [ElectionController::class, 'edit'])->name('elections.edit');
    Route::put('/elections/{id_election}', [ElectionController::class, 'update'])->name('elections.update');
    Route::delete('/elections/{id_election}', [ElectionController::class, 'destroy'])->name('elections.destroy');
    Route::get('/elections/{id_election}/export/votes/csv', [ElectionController::class, 'exportVotesCsv'])->name('elections.export.votes.csv');
    Route::get('/elections/{id_election}/export/votes/pdf', [ElectionController::class, 'exportVotesPdf'])->name('elections.export.votes.pdf');

    // Routes pour les candidats
    Route::get('/elections/{id_election}/candidats', [CandidatController::class, 'index'])->name('candidats.index');
    Route::get('/elections/{id_election}/candidats/create', [CandidatController::class, 'create'])->name('candidats.create');
    Route::post('/elections/{id_election}/candidats', [CandidatController::class, 'store'])->name('candidats.store');
    Route::get('/elections/{id_election}/candidats/{id_candidat}/edit', [CandidatController::class, 'edit'])->name('candidats.edit');
    Route::put('/elections/{id_election}/candidats/{id_candidat}', [CandidatController::class, 'update'])->name('candidats.update');
    Route::delete('/elections/{id_election}/candidats/{id_candidat}', [CandidatController::class, 'destroy'])->name('candidats.destroy');
    Route::post('/elections/{id_election}/candidats/{id_candidat}/comment', [CandidatController::class, 'comment'])->name('candidats.comment');
    Route::get('/elections/{id_election}/candidats/{id_candidat}/comments/{id_comment}/edit', [CandidatController::class, 'editComment'])->name('candidats.comment.edit');
    Route::put('/elections/{id_election}/candidats/{id_candidat}/comments/{id_comment}', [CandidatController::class, 'updateComment'])->name('candidats.comment.update');
    Route::delete('/elections/{id_election}/candidats/{id_candidat}/comments/{id_comment}', [CandidatController::class, 'destroyComment'])->name('candidats.comment.destroy');

    // Routes pour les votes
    Route::get('/elections/{id_election}/vote', [VoteController::class, 'create'])->name('votes.create');
    Route::post('/elections/{id_election}/vote', [VoteController::class, 'store'])->name('votes.store');
    Route::get('/elections/{id_election}/votes/import', [VoteController::class, 'import'])->name('votes.import');
    Route::post('/elections/{id_election}/votes/import', [VoteController::class, 'importCsv'])->name('votes.import.csv');
    Route::get('/elections/{id_election}/votes/{id_vote}/edit', [VoteController::class, 'edit'])->name('votes.edit');
    Route::put('/elections/{id_election}/votes/{id_vote}', [VoteController::class, 'update'])->name('votes.update');
    Route::delete('/elections/{id_election}/votes/{id_vote}', [VoteController::class, 'destroy'])->name('votes.destroy');
});
