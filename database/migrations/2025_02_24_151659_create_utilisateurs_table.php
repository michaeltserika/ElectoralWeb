<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('utilisateurs', function (Blueprint $table) {
        $table->id('id_utilisateur');
        $table->string('nom', 100);
        $table->string('email', 100)->unique();
        $table->string('mot_de_passe', 255);
        $table->enum('role', ['ADMIN', 'VOTANT'])->default('VOTANT');
        $table->rememberToken(); // Ajouté pour Breeze
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
