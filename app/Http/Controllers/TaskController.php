<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home(){

        $user = User::find(Auth::id());
 
         
 
         $taches = $user->tasks()->orderBy('finish_at', 'asc')->limit(6)->get();
 
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

        $tasks = Task::all();

        foreach($tasks as $task)
        {
            $task->user_id = Auth::id();
            $task->save();
        }

         $taches = $user->tasks()->orderBy('finish_at', 'asc')->orderBy('created_at', 'asc')->paginate(15);
 
         
 
         return view('task.index', [
             'taches' => $taches,
 
         ]);
     }
     public function tachesEncours()
     {
         /* $date = Carbon::create(now());
         $date->addDays(30); */
 
         $user = User::find(Auth::id());
 
 
 
         $taches = $user->tasks()->whereNotNull('beginned_at')->whereNull('finished_at')->orderBy('finish_at', 'asc')->paginate(15);
 
         return view('task.en_cours', [
             'taches' => $taches
         ]);
     }
     public function tachesAVenir()
     {
         /* $date = Carbon::create(now());
         $date->addDays(30); */
 
         $user = User::find(Auth::id());
 
 
 
         $taches = $user->tasks()->whereNull('beginned_at')->orderBy('begin_at', 'asc')->paginate(15);
 
         return view('task.a_venir', [
             'taches' => $taches
         ]);
     }
 
     public function tachesTerminees()
     {
         /* $date = Carbon::create(now());
         $date->addDays(30); */
 
         $user = User::find(Auth::id());
 
 
 
         $tachesTerminees = $user->tasks()->whereNotNull('finished_at')->orderBy('finished_at', 'asc')->paginate(15);
 
         return view('task.terminees', [
 
             
             'taches' => $tachesTerminees
         ]);
     }
 
     public function marqueToFinish ($id){
         $task = Task::find($id);
 
         if($task->finished_at !== null)
         {
            return to_route('task.index')->with('success', 'Tache: '.$task->name . 'était déjà marquée comme terminée');
         }

         $task->finished_at = now();
 
         $task->save();
 
         return to_route('task.index')->with('success', 'Tache: '.$task->name . ' marquée comme terminée');
     }
     public function marqueToBegin  ($id)
     {

         $task = Task::find($id);

         if($task->beginned_at !== null)
         {
            return to_route('task.index')->with('success', 'Tache: '.$task->name . 'était déjà marquée comme démarrée');
         }
 
         $task->beginned_at = now();
 
         $task->save();
 
         return to_route('task.index')->with('success', 'Tache: '.$task->name . ' démarrée');
     }

 
     public function statistiques(){
 
 
         $user = User::find(Auth::id());
 
         $nbrTotalTaches = $user->tasks()->count();
 
         $nbrTachesTerminees = $user->tasks()->whereNotNull('finished_at')->count();
         $nbrTachesTermineesEnRetard = $user->tasks()->whereNotNull('finished_at')->whereDate('finished_at', ">", DB::raw('finish_at'))->count();
 
         $nrbTachesNondemarrees =  $user->tasks()->whereNull('beginned_at')->count();
 
         $nbrTachesEnCours = $user->tasks()->whereNotNull('beginned_at')->whereNull('finished_at')->count();
         $nbrTachesDemarreesEnRetard = $user->tasks()->whereNotNull('beginned_at')->whereNull('finished_at')->whereDate('beginned_at', ">", DB::raw('begin_at'))->count();
 
         
         return view('dashboard', [
             'nbrTotalTaches' => $nbrTotalTaches,
             'nbrTachesTerminees' => $nbrTachesTerminees,
             'nbrTachesTermineesEnRetard' => $nbrTachesTermineesEnRetard,
             'nrbTachesNondemarrees' => $nrbTachesNondemarrees,
             'nbrTachesEnCours' => $nbrTachesEnCours,
             'nbrTachesDemarreesEnRetard' => $nbrTachesDemarreesEnRetard,
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
     public function create()
     {
         
         return view('task..edit', [
             'tache' => new Task()
         ]);
     }
 
     /**
      * Store a newly created resource in storage.
      */
     public function store(TaskRequest $request, Task $tache)
     {
 
         $id = Auth::id();
 
         $data = [
             'name' => $request->validated('name'),
             'description' => $request->validated('description'),
             'begin_at' => $request->validated('begin_at'),
             'finish_at' => $request->validated('finish_at'),
             'beginned_at' => $request->input('beginned_at'),
             'finishes_at' => $request->input('finishes_at'),
             'notifiable' => $request->input('notifiable'),
             'user_id' => $id
         ];
 
             $tache = Task::create($data);
             $tache->user()->associate($id);
             $tache->save();
         return to_route('task.index')->with('success', 'Tache créée avec succès');
     }
 
     /**
      * Display the specified resource.
      */

 
     /**
      * Show the form for editing the specified resource.
      */
     public function edit( $tache)
     {
         $tache = Task::find($tache);
         return view('task.edit', [
             'tache' => $tache
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

        return to_route('task.index')->with('success', 'Task modified success');
      }
 
     /**
      * Remove the specified resource from storage.
      */
     public function destroy($tache)
     {
         $tache = Task::find($tache);
 
         $tache->delete();
 
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
        $tasks = $user->tasks()->whereNotNull('beginned_at')->whereNotNull('finished_at')->whereDate('finished_at', '>', DB::raw('finish_at'))->paginate(15);

        return view('task.terminees_retard', [
            'tasks' => $tasks,
        ]);
    }
    
}

