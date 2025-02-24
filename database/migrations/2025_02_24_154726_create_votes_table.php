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
    Schema::create('votes', function (Blueprint $table) {
        $table->id('id_vote');
        $table->foreignId('id_utilisateur')->constrained('utilisateurs', 'id_utilisateur')->onDelete('cascade');
        $table->foreignId('id_election')->constrained('elections', 'id_election')->onDelete('cascade');
        $table->foreignId('id_candidat')->constrained('candidats', 'id_candidat')->onDelete('cascade');
        $table->timestamp('date_vote')->useCurrent();
        $table->unique(['id_utilisateur', 'id_election']);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
