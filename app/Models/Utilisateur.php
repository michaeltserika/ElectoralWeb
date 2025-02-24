<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use Notifiable;

    protected $table = 'utilisateurs';
    protected $primaryKey = 'id_utilisateur';
    protected $fillable = ['nom', 'email', 'mot_de_passe', 'role', 'image', 'ce_number', 'cin_number', 'date_of_birth'];

    protected $hidden = ['mot_de_passe', 'remember_token'];

    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'id_utilisateur');
    }

    // Méthode pour calculer l'âge
    public function getAgeAttribute()
    {
        return $this->date_of_birth ? now()->diffInYears($this->date_of_birth) : null;
    }
}
