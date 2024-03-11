<?php

use App\Models\Couleur;
use App\Models\Marque;
use App\Models\Mode;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class,"marchand");
            $table->string("nom",255);
            $table->text("description");
            $table->decimal("prix");
            $table->string("devise",2);
            $table->integer("nbr");
            $table->integer("nbrVendus")->default(0);
            $table->string("pathImg")->unique()->nullable();
            $table->foreignIdFor(Marque::class);
            $table->foreignIdFor(Type::class);
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
        Schema::dropIfExists('articles');
    }
}
