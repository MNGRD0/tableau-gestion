<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('email_client');
            $table->string('telephone_client', 17);
            $table->string('adresse_client');
            $table->string('cp_client', 10);
            $table->string('ville_client');
            $table->string('commentaire_client')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client');
        Schema::table('client', function (Blueprint $table) {
            $table->dropColumn('commentaire_client');
        });
        
    }
};
