<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function tasks(){
        return $this->hasMany(Task::class);
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }


    public function user(){ 
        return $this->belongsTo(User::class);
    }
}
