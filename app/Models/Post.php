<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'title',
        'slug',
        'content',
        'category_id'
    ];

    //afinde notifier que cette article là appartient à une catégorie
    //on crée cette fonction qui'sappelle category, le nom de la relation. Ce
   //la methode bLongTo permet de dire que cet article là appartient à une catégorie 
   //En parametre, il prend la class Post
   /* Si on repecte les bonnes conventions de nommages, on a rien à faire
   elle devine quelle est la clé etrangere à cette étape return $this->belongsTo(Category::class);*/

   public function category(){
    
    return $this->belongsTo(Category::class);
   }


   //relation belogsToMany, pour dire qu'un article à plusieurs tags
   public function tags() {
    return $this->belongsToMany(Tag::class);
   }
}
