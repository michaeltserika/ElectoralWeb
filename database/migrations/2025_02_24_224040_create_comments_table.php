<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id('id_comment');
            $table->foreignId('id_utilisateur')->constrained('utilisateurs', 'id_utilisateur')->onDelete('cascade');
            $table->foreignId('id_candidat')->constrained('candidats', 'id_candidat')->onDelete('cascade');
            $table->text('content');
            $table->foreignId('parent_id')->nullable()->constrained('comments', 'id_comment')->onDelete('cascade'); // Pour les réponses
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
