<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBancairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bancaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('numAgence');
            $table->string('codePays');
            $table->string('numCompte')->unique();
            $table->string('type');
            $table->string('rib')->unique();
            $table->string('social')->nullable();
            $table->string('adresse')->nullable();
            $table->string('employeur')->nullable();
            $table->string('identifiant')->nullable();
            $table->string('solde')->default('0');
            $table->string('solde_prec')->default('0');
            $table->string('etat')->default(true);
            $table->string('date_fin')->nullable();
            $table->string('renumeration')->nullable();
            $table->string('frais_ouverture')->nullable();
            $table->string('frais_releve')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bancaires');
    }
}
