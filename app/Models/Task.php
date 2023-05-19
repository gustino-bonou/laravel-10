<?php

namespace App\Models;

use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{

    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'begin_at',
        'finish_at',
        'beginned_at',
        'finished_at',
        'notifiable',
    ];

    //pour renvoyer les champs date sous forme de date carbon

    //protected $dates = ['begin_at', 'finish_at', 'beginned_at', 'beginned_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function getDate(string $date){
        
        $date = Carbon::parse($date);   

        return $date->translatedFormat('d F Y H:i');
    }

    public function parseDateInCarbon($date)
    {
        return Carbon::parse($date);
    }
    public function getDiffInDates($date1, $date2)
    {
        $date1 = Carbon::parse($date1);
        $date2 = Carbon::parse($date2);

        return $date1->diffInDays($date2);
    }
    public function getTaskStatus() 
    {
        $status = '';
        
        if($this->beginned_at !== null && $this->finished_at !== null)
        {
            $status = 'Terminée';
        }
        elseif($this->beginned_at == null)
        {
            $status = 'Non démarrée';
        }
        elseif($this->beginned_at !== null && $this->finished_at == null)
        {
            $status = 'En cours';
        }

        return $status;
    }
}
