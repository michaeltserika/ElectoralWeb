<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdentityToUtilisateursTable extends Migration
{
    public function up()
    {
        Schema::table('utilisateurs', function (Blueprint $table) {
            $table->string('ce_number')->nullable(); // Numéro de Carte d'Étudiant
            $table->string('cin_number')->nullable(); // Numéro de Carte d'Identité Nationale
            $table->date('date_of_birth')->nullable(); // Date de naissance pour vérifier l'âge
        });
    }

    public function down()
    {
        Schema::table('utilisateurs', function (Blueprint $table) {
            $table->dropColumn(['ce_number', 'cin_number', 'date_of_birth']);
        });
    }
}
