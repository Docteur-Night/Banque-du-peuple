<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            //foreign Key
            $table->foreignId('user_id')->constrained();
            //-------------------------------------------
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('adresse');
            $table->string('profession');
            $table->string('salaire')->nullable();
            $table->string('tel');
            $table->string('avatar')->nullable();
            $table->text('infos')->nullable();
            $table->string('identifiant')->unique();
            $table->string('numAgence');
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
        Schema::dropIfExists('clients');
    }
}
