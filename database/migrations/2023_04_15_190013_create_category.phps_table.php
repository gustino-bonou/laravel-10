<?php

use App\Models\Category;
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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        //Dans le cadre du tuto sur les relations, on est appelé à ajouter une table categories
        //Ainsi, on doit modifier la table posts(ajouter la colonne category_id) qui était déjà créée afin qu'elle
        //puisse prendre en compte la relation un à un(un article ne peut
        //avoir qu'une seule catégorie). Pout cette on a le code suivant qui permet de faire appel 
        //à la table "posts" et d'en ajouter la colonne category_id grace à foreignIdFor

        Schema::table('posts', function (Blueprint $table) {
            $table->foreignIdFor(Category::class)->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');

        //au cas où on reviendrais en arriere sur cette migration, on souhait que la foreignkey soit supprimé, 
        //raison du code suivant
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeignIdFor(Category::class);
        });
    }
};
