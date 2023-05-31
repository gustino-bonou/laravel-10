<?php

namespace App\Models;

use App\Models\User;
use App\Models\Group;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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
    public function comments(){
        return $this->belongsTo(Comment::class);
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

        if($date1->diffInDays($date2) === 0)
        {
            return $date1->diffAsCarbonInterval($date2);
        }

        return $date1->diffInDays($date2) . ' Jours';
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
            $status = 'Nom démarree';
        }
        elseif($this->beginned_at !== null && $this->finished_at == null)
        {
            $status = 'En cours';
        }

        return $status;
    }


    public function scopeTasksEnCours(Builder $builder)
    {
        return $builder->whereNotNull('beginned_at')->whereNull('finished_at')->orderBy('finish_at', 'asc');
    }

    public function scopeTasksNonDemarrees(Builder $builder)
    {
        return $builder->whereNull('beginned_at')->orderBy('beginned_at', 'asc');
    }
    public function scopeTasksDemarreesEnRetard(Builder $builder)
    {
        return $builder->where('group_id', '=', null) ->whereNotNull('beginned_at')->whereColumn('beginned_at', ">", 'begin_at');
    }

    public function scopeTasksTerminees(Builder $builder)
    {
        return $builder->whereNotNull('beginned_at')->whereNotNull('finished_at')->orderBy('finished_at', 'asc');
    }

    public function scopeTasksTermineesRetard(Builder $builder)
    {
        return $builder->whereColumn('finished_at', '>=', 'finish_at')->tasksTerminees();
    }
    public function scopeHomeTasks(Builder $builder)
    {
        return $builder->whereNull('finished_at')->whereDate('finish_at', '<=', Carbon::now()->addDays(5))->orderBy('finish_at', 'asc')->limit(6);
    }
}
