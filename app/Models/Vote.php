<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $table = 'votes';
    protected $primaryKey = 'id_vote';
    protected $fillable = ['id_utilisateur', 'id_election', 'id_candidat', 'date_vote'];

    protected $casts = [
        'date_vote' => 'datetime', // Formatage automatique
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

    public function election()
    {
        return $this->belongsTo(Election::class, 'id_election');
    }

    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'id_candidat');
    }
}
