<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    protected $table = 'candidats';
    protected $primaryKey = 'id_candidat';
    protected $fillable = ['id_election', 'nom', 'programme', 'image'];

    public function election()
    {
        return $this->belongsTo(Election::class, 'id_election');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'id_candidat');
    }

    // Ajout de la relation avec les commentaires
    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_candidat');
    }
}
