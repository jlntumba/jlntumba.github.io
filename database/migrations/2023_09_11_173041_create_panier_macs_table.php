<?php

use App\Models\Article;
use App\Models\Couleur;
use App\Models\Mode;
use App\Models\Taille;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanierMacsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panier_macs', function (Blueprint $table) {
            $table->foreignIdFor(Article::class);
            $table->macAddress("mac");
            $table->foreign("mac")->references("mac")->on("macs")->onDelete('cascade');
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
        Schema::dropIfExists('panier_macs');
    }
}
