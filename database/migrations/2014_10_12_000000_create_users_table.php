<?php

use App\Models\Adresse;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('profil',500)->nullable();
            $table->string('name',255);
            $table->string('postnom',255);
            $table->string('prenom',255);
            $table->string('entreprise',255)->nullable();
            $table->string('sexe',255);
            $table->string('tel')->unique();
            $table->string('code')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->foreignIdFor(Adresse::class)->nullable();
            $table->string('password');
            $table->foreignIdFor(Role::class)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->integer("nbrArtPost")->default(0);
            $table->integer("nbrArtVend")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
