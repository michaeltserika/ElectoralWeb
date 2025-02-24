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
    Schema::create('candidats', function (Blueprint $table) {
        $table->id('id_candidat');
        $table->foreignId('id_election')->constrained('elections', 'id_election')->onDelete('cascade');
        $table->string('nom', 100);
        $table->text('programme')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidats');
    }
};
