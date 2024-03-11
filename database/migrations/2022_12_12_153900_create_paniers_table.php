<?php

use App\Models\Article;
use App\Models\Couleur;
use App\Models\Mode;
use App\Models\Taille;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaniersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paniers', function (Blueprint $table) {
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Article::class);
            $table->foreignIdFor(Mode::class);
            $table->foreignIdFor(Taille::class)->nullable();
            $table->foreignIdFor(Couleur::class);
            $table->integer('qte');
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
        Schema::dropIfExists('paniers');
    }
}
