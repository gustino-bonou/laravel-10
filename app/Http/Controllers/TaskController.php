<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Models\Group;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function homeTasks(){

        $user = User::find(Auth::id());
 
         
 
         $taches = $user->tasks()->homeTasks()->where('group_id', '=', null)->get();
 
         return view('task.home', [
 
             
             'taches' => $taches,
 
         ]);
      }
 
     public function index()
     {
         /* $date = Carbon::create(now());
         $date->addDays(30); */
 
         $taches = Task::all();
         
        $user = User::find(Auth::id());

         $taches = $user->tasks()->where('group_id', '=', null) ->orderBy('finish_at', 'asc')->orderBy('created_at', 'asc')->paginate(15);
 
         return view('task.index', [
             'taches' => $taches,
 
         ]);
     }
     public function tachesEncours()
     {

 
         $user = User::find(Auth::id());
 
 
 
         $taches = $user->tasks()->where('group_id', '=', null) ->tasksEnCours()->paginate(15);
 
         return view('task.en_cours', [
             'taches' => $taches
         ]);
     }
     public function tachesAVenir()
     {
         /* $date = Carbon::create(now());
         $date->addDays(30); */
 
         $user = User::find(Auth::id());
 
 
 
         $taches = $user->tasks()->where('group_id', '=', null)->tasksNonDemarrees()->paginate(15);
 
         return view('task.a_venir', [
             'taches' => $taches
         ]);
     }
 
     public function tachesTerminees()
     {

 
         $user = User::find(Auth::id());
 
 
 
         $tachesTerminees = $user->tasks()->where('group_id', '=', null) ->tasksTerminees()->paginate(15);
 
         return view('task.terminees', [
 
             
             'taches' => $tachesTerminees
         ]);
     }
 
     public function marqueToFinish ($task){
         $task = Task::find($task);
 
         if($task->finished_at !== null)
         {
            return to_route('task.en_cours')->with('success', 'Tache: '.$task->name . '  marquée comme terminée');
         }

         $task->finished_at = now();
 
         $task->save();
 
         return to_route('task.en_cours')->with('success', 'Tache: '.$task->name . '  marquée comme terminée');
     }
     public function marqueToBegin  ($task)
     {

         $task = Task::find($task);

         if($task->beginned_at !== null)
         {
            return to_route('task.a_venir')->with('success', 'Tache: '.$task->name . 'était déjà marquée comme démarrée');
         }
 
         $task->beginned_at = now();
 
         $task->save();
 
         return to_route('task.a_venir')->with('success', 'Tache: '.$task->name . '  marquée comme démarrée');
     }

 
     public function statistiques(){
 

        
 
         $user = User::find(Auth::id());

         $tasksEcheanceProches = $user->tasks()->where('group_id', null)->homeTasks()->get();
 
         $nbrTotalTaches = $user->tasks()->where('group_id', '=', null) ->count();
 
         $nbrTachesTerminees = $user->tasks()->where('group_id', '=', null) ->whereNotNull('finished_at')->count();
         $nbrTachesTermineesEnRetard = $user->tasks()->where('group_id', '=', null) ->whereNotNull('finished_at')->whereDate('finished_at', ">", DB::raw('finish_at'))->count();
 
         $nrbTachesNondemarrees =  $user->tasks()->where('group_id', '=', null) ->whereNull('beginned_at')->count();
 
         $nbrTachesEnCours = $user->tasks()->where('group_id', '=', null) ->whereNotNull('beginned_at')->whereNull('finished_at')->count();
         $nbrTachesDemarreesEnRetard = $user->tasks()->where('group_id', '=', null) ->whereNotNull('beginned_at')->whereNull('finished_at')->whereDate('beginned_at', ">", DB::raw('begin_at'))->count();
 
         
         return view('dashboard', [
             'nbrTotalTaches' => $nbrTotalTaches,
             'nbrTachesTerminees' => $nbrTachesTerminees,
             'nbrTachesTermineesEnRetard' => $nbrTachesTermineesEnRetard,
             'nrbTachesNondemarrees' => $nrbTachesNondemarrees,
             'nbrTachesEnCours' => $nbrTachesEnCours,
             'nbrTachesDemarreesEnRetard' => $nbrTachesDemarreesEnRetard,
             'tasksEcheanceProches' =>$tasksEcheanceProches,
         ]);
     }
 
     public function setNotifiableColumn($tache){
 
         $tache = Task::find($tache);
         $tache->notifiable = false;
         $tache->save();
 
         return to_route('task.edit', $tache)->with('success', 'Vous n\'allez plus recevoir de notifications pour cette tache');
 
     }
 
     /**
      * Show the form for creating a new resource.
      */
     public function create($group = null)
     {
         
         return view('task.edit', [
             'tache' => new Task(),
             'group' => $group,
         ]);
     }
 
     /**
      * Store a newly created resource in storage.
      */
     public function store(TaskRequest $request, Task $tache)
     {


        
 
         $user_id = Auth::id();
 
         $data = [
             'name' => $request->validated('name'),
             'description' => $request->validated('description'),
             'begin_at' => $request->validated('begin_at'),
             'finish_at' => $request->validated('finish_at'),
             'beginned_at' => $request->input('beginned_at'),
             'finishes_at' => $request->input('finishes_at'),
             'notifiable' => $request->input('notifiable'),
         ];
 
         $tache = Task::create($data);

         
         $tache->user()->associate($user_id);
        

         $tache->group()->associate($request->input('group_id'));
         $tache->level = $request->input('level');
         
         $tache->save();

         
         if($tache->group_id !== null)
         {
            return to_route('group.workspace', [
                'group' => $tache->group_id,
            ])->with('success', 'Tache créée avec succès');
         }

         return to_route('task.index')->with('success', 'Tache créée avec succès');
     }
 
     /**
      * Display the specified resource.
      */

 
     /**
      * Show the form for editing the specified resource.
      */
     public function edit(Request $request,  $tache)
     {



         $tache = Task::find($tache);


        

         $taskComments = null;

         if($tache->group_id !== null)
         {
            $group = Group::find($tache->group_id);
            $taskComments = $group->comments()->orderBy('created_at', 'asc')->paginate(4);
         }

         return view('task.edit', [
             'tache' => $tache,
             'group' => $tache->group_id,
             'taskComments' => $taskComments
         ]);
     }
 
     /**
      * Update the specified resource in storage.
      */

      public function update(TaskRequest $request, Task $task)
      {

        $task->update($request->validated());

        $task->level = $request->validated('level');


        $task->save();

        if($task->group_id !== null)
         {
            return to_route('group.workspace', [
                'group' => $task->group_id,
            ])->with('success', 'Tache modifiéee avec succès');
         }

        return to_route('task.index')->with('success', 'Task modified success');
      }
 
     /**
      * Remove the specified resource from storage.
      */
     public function destroy($tache)
     {
         $tache = Task::find($tache);

         $group = $tache->group_id;
 
         $tache->delete();

         if($group !== null)
         {
            return to_route('group.workspace', [
                'group' => $group
            ]);
         }
 
         return back()->with('Suppression effectuée avec succès');
     }
 
     public function dashoard(){
         $user = User::find(Auth::id());
 
         $nbrTotalTaches = $user->taches()->count();
 
         $nbrTachesTerminees = $user->taches()->whereNotNull('finished_at')->count();
         $nbrTachesTermineesEnRetard = $user->taches()->whereNotNull('finished_at')->whereDate('finished_at', ">", DB::raw('finish_at'))->count();
 
         $nrbTachesNondemarrees =  $user->taches()->whereNull('beginned_at')->count();
 
         $nbrTachesEnCours = $user->taches()->whereNotNull('beginned_at')->whereNull('finished_at')->count();
         $nbrTachesDemarreesEnRetard = $user->taches()->whereNotNull('beginned_at')->whereNull('finished_at')->whereDate('beginned_at', ">", DB::raw('begin_at'))->count();
 
     
         return view('dashboard', [
             'nbrTotalTaches' => $nbrTotalTaches,
             'nbrTachesTerminees' => $nbrTachesTerminees,
             'nbrTachesTermineesEnRetard' => $nbrTachesTermineesEnRetard,
             'nrbTachesNondemarrees' => $nrbTachesNondemarrees,
             'nbrTachesEnCours' => $nbrTachesEnCours,
             'nbrTachesDemarreesEnRetard' => $nbrTachesDemarreesEnRetard,
         ]);
     }

     public function tasksTermineesRetard(){

        $user = User::find(Auth::id());
        $tasks = $user->tasks()->tasksTermineesRetard()->paginate(15);

        return view('task.terminees_retard', [
            'tasks' => $tasks,
        ]);
    }
    
}

