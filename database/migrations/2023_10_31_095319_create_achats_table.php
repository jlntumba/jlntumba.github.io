<?php

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achats', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class,"acheteur");
            $table->foreignIdFor(User::class,"marchand");
            $table->bigInteger('article_id');
            $table->string("nom",255);
            $table->text("description");
            $table->decimal("prix");
            $table->string("devise",2);
            $table->string("pathImg");
            $table->string("marque");
            $table->string("mode");
            $table->string("type");
            $table->string("taille")->nullable();
            $table->string("couleur");
            $table->string("color");
            $table->integer('qte');
            $table->timestamp('datePaiement');
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
        Schema::dropIfExists('achats');
    }
}
