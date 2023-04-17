<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /* Pour qu'on soit capable de créer des champs */
    protected $fillable = ['name'];

    public function posts(){
        return $this->hasMany(Post::class);
    }
}
