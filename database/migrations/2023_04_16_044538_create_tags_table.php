<?php

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        /* ici il y une relation plusieurs à plusieurs(manyToMany) 
        On precise cela ainsi:
        Avec cette relation, il va falloir créer une table intermediaire avec shema::crete
        La convention est d'ecrire les noms des tables au singulier, par ordre alphabetique
        Ensuite on contruit la fonction permettant de spécifier comment construire les chose
        Le foreignIdFor, c'est le mot clé pour dire ceci est est une clé etrangère, cest une fonction
        qui prend la class d'où vient la clé étrangère
        */

        Schema::create('post_tag', function (Blueprint $table) {
            //clé étrangète post_id
            $table->foreignIdFor(Post::class)->constained()->cascadeOnDelete();

            //clé étrangète tag_id
            $table->foreignIdFor(Tag::class)->constained()->cascadeOnDelete();

            //clé primere
            $table->primary(['post_id', 'tag_id']);
        });

        //NB: les liaisons sont faitest dans les models
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_tag');
        Schema::dropIfExists('tags');
    }
};
