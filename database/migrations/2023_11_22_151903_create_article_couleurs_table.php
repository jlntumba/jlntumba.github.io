<?php

use App\Models\Article;
use App\Models\Couleur;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleCouleursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_couleurs', function (Blueprint $table) {
            $table->foreignIdFor(Article::class);
            $table->foreignIdFor(Couleur::class);
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
        Schema::dropIfExists('article_couleurs');
    }
}
