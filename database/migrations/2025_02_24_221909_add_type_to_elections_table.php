<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToElectionsTable extends Migration
{
    public function up()
    {
        Schema::table('elections', function (Blueprint $table) {
            $table->enum('type', ['etablissement', 'communal', 'administratif'])->default('etablissement');
        });
    }

    public function down()
    {
        Schema::table('elections', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
