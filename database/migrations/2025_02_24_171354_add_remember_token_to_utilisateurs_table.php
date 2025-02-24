<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 public function up()
{
    Schema::table('utilisateurs', function (Blueprint $table) {
        $table->rememberToken();
    });
}

public function down()
{
    Schema::table('utilisateurs', function (Blueprint $table) {
        $table->dropColumn('remember_token');
    });
}

};
