<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * Les attributs qui peuvent être remplis en masse.
     *
     * @var array
     */
    protected $fillable = ['id_utilisateur', 'message', 'read'];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array
     */
    protected $casts = [
        'read' => 'boolean',
    ];

    /**
     * Relation avec le modèle Utilisateur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }
}
