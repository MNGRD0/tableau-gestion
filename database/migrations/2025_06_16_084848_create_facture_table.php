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
        Schema::create('facture', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('client')->onDelete('cascade'); //Rajout de client à l'intérieur de constrained parce que j'ai pas mis de "s".
            $table->string('nom_client');
            $table->decimal('montant', 10,2);
            $table->enum('moyen_paiement', ['chèque', 'espèces','carte bancaire', 'autre']);
            $table->boolean('echelonner')->default(false);
            $table->enum('statut_facture', ['payée', 'non payée']);
            $table->string('commentaire_facture')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facture');
    }
};
