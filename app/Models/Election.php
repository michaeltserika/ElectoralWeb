<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    protected $table = 'elections';
    protected $primaryKey = 'id_election';
    protected $fillable = ['titre', 'date_debut', 'date_fin', 'type'];

    public function candidats()
    {
        return $this->hasMany(Candidat::class, 'id_election');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'id_election');
    }

    // Vérifier si l'élection est clôturée
    public function isClosed()
    {
        return now()->gt($this->date_fin);
    }
}
