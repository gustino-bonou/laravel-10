<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use Notification;
use App\Models\Task;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PhpParser\Node\Stmt\Return_;
use App\Http\Requests\GroupRequest;
use App\Http\Requests\SearchUserRequest;
use App\Notifications\AssignRoleToUserNotif;
use App\Http\Requests\AssignRoleToUserRequest;
use App\Notifications\InviteUserToJoinGroupNotification;
use App\Notifications\AssignedTaskToUserInGroupNotification;
use App\Events\SendNotificationToUserConfiedTaskInGroupEvent;
use DB;
use Illuminate\Database\Eloquent\Builder;

class GroupController extends Controller
{

    public function __construct()
    {
       
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = User::find(Auth::id());

        $groups = $user->groupsWhenImAuthor()->paginate(9);

        return view('group.index', [
            'groups' => $groups
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('group.edit', [
            'group' => new Group()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupRequest $request)
    {
        $group = Group::create($request->validated());

        $group->user()->associate(Auth::id());

        $group->users()->toggle(Auth::id());

        $group->save();

        return to_route('group.index')->with('success', 'Groupe créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {

        $allUsers = User::paginate(10);

        return view('group.edit', [
            'group' => $group,
            'allUsers' => $allUsers
        ]); 
    }
    public function workspace(Group $group, SearchUserRequest $request)
    {
        //dd(Auth::user()->can('inviteUserToJoinGroup', [$group]));
        //dd(Auth::user()->can('workspace', [$group]));

        $groupId = $group->id;

        //on recupere tous les utilisateurs sans ceux appartenant au groupe en question
        $users = User::whereDoesntHave('groupsWhenImJoineds', function ($query) use ($groupId) {
            $query->where('group_id', $groupId);
        })->orderBy('name');

        $homeTasks = $group->tasks()->homeTasks()->get();

        if($request->validated('name'))
        {
            $users = $users->where('name', 'like', "%{$request->validated('name')}%");
        }

        return view('group.workspace', [

            'group' => $group,
            'homeTasks' =>$homeTasks,
            'allUsers' => $users->paginate(10),
            'input' => $request->validated()
        ]); 
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }

    public function inviteUserToJoinGroup($group, $user)
    {
        $group = Group::findOrFail($group);
        $user = User::findOrFail($user);

        $user->notify(new  InviteUserToJoinGroupNotification($group, $user)) ;

        return back();
    }

    public function attachUserToGroup($group, $user)
    {
        $group = Group::findOrFail($group);
        $user = User::findOrFail($user);

        $group->users()->syncWithoutDetaching($user);

        return to_route('group.workspace', [
            'group' =>$group->id
        ])->with('success', 'Vous faites desormais partie de ce groupe');
    }

    public function detachUserOnGroup($group)
    {
        $group = Group::findOrFail($group);

        $group->users()->detach(Auth::id());

        return to_route('home');
    }

    public function viewToAssignRolToUser($group, $task)
    {
        $task = Task::findOrFail($task);
        $group = Group::findOrFail($group);

        $users = $group->users()->orderBy('name')->get();

        return view('group.assignRols', [
            'group' =>$group,
            'task' =>$task,
            'users' =>$users,
        ]);
    }

    public function assinRolToUser($task, AssignRoleToUserRequest $request)
    {

        $task = Task::findOrFail($task);

        $task->users()->syncWithoutDetaching($request->validated('users'));

        $group = Group::find($task->group_id);

        foreach(array_values($request->validated('users')) as $value)
        {
            $user = User::findOrFail($value);

            //notification enrégistrée dans la base de données

           // $user->notify(new AssignRoleToUserNotif($group, $user, $task));


            //notification envoyée par mail grace à un event
            event(new SendNotificationToUserConfiedTaskInGroupEvent($group, $user, $task));

        }
        return to_route('task.edit', [
            'task' => $task->id
        ]);
    }


    public function detachUserOnGroupTask($task, $user)
    {

        $task = Task::findOrFail($task);

        $task->users()->detach($user);

        return back();
    }


    public function groupTasks($group)
     {
          
        $group = Group::find($group);

        $tasks = $group->tasks()->orderBy('finish_at', 'asc')->orderBy('created_at', 'asc')->paginate(15);
 
         return view('group.task.index', [
             'tasks' => $tasks,
             'group' => $group
         ]);
     }

     public function tachesEncours($group)
     {

        $group = Group::findOrFail($group);

        $tasks = $group->tasks()->tasksEnCours()->paginate(15);

         return view('group.task.en_cours', [
             'tasks' => $tasks,
             'group' => $group
         ]);
     }
     public function tachesNonDemarrees($group)
     {
         /* $date = Carbon::create(now());
         $date->addDays(30); */
 
         $group = Group::findOrFail($group);

        $tasks = $group->tasks()->tasksNonDemarrees()->paginate(15);
         return view('group.task.a_venir', [
             'tasks' => $tasks,
             'group' => $group
         ]);
     }
 
     public function tachesTerminees($group)
     {
    
        $group = Group::findOrFail($group);

        $tasks = $group->tasks()->tasksTerminees()->paginate(15);
 
         return view('group.task.terminees', [
             'tasks' => $tasks,
             'group' => $group
         ]);
     } 
     public function tachesTermineesEnRetard($group)
     {
    
        $group = Group::findOrFail($group);

        $tasks = $group->tasks()->tasksTermineesRetard()->paginate(15);
 
         return view('group.task.terminees_retard', [
             'tasks' => $tasks,
             'group' => $group
         ]);
     } 
     public function myTasksInTheGroup($group)
     {
    
        $group = Group::findOrFail($group);


        //ici on recupere les tasks qui sont impliquées dans une relation belongToMany
        //et qui dans ces relations(la table "task_user"), le user_id est egale à l'id de Auth
        //Par la suite on filtre ces taches en recuperant celle dont le group_id est égale au group dourni en argument
        $tasks = Task::whereHas('users', function($query) {
            $query->where('user_id', Auth::id());
        })->where('group_id', $group->id)->get();
 
        return view('group.task.myTasks', [
            'myTasks' => $tasks,
            'group' => $group
        ]);
     } 
     public function groupsWhenImMember()
     {
    
        $groups = Group::whereHas('users', function($query) {
            $query->where('user_id', Auth::id());
        })->where('user_id', '!=', Auth::id())->get();

        return view('group.groups_im_member', [
            'groups' => $groups
        ]);
      
     } 
}

/* 
Pour mettre en place un système de tag en Laravel, où un utilisateur peut taguer un autre utilisateur sur un commentaire, vous pouvez suivre les étapes suivantes :

Créez une table de pivot pour gérer la relation de tag entre les utilisateurs. Vous pouvez créer une migration pour cela en utilisant la commande artisan suivante :
bash
Copy code
php artisan make:migration create_comment_tag_table --create=comment_tag
Dans la migration générée, vous pouvez définir les colonnes nécessaires, telles que comment_id, user_id (pour l'utilisateur qui taggue) et tagged_user_id (pour l'utilisateur tagué). Assurez-vous de définir les relations appropriées dans votre modèle Comment et User.

Dans votre modèle Comment, définissez une relation many-to-many pour les utilisateurs tagués :
php
Copy code
public function taggedUsers()
{
    return $this->belongsToMany(User::class, 'comment_tag', 'comment_id', 'tagged_user_id');
}
Cela permettra de récupérer les utilisateurs tagués pour un commentaire donné.

Dans votre modèle User, définissez une relation many-to-many pour les commentaires tagués par cet utilisateur :
php
Copy code
public function taggedComments()
{
    return $this->belongsToMany(Comment::class, 'comment_tag', 'tagged_user_id', 'comment_id');
}
Cela permettra de récupérer les commentaires où l'utilisateur est tagué.

Pour ajouter un tag à un commentaire, vous pouvez utiliser la méthode attach() de la relation many-to-many dans votre contrôleur. Par exemple :
php
Copy code
$comment = Comment::find($commentId);
$taggedUserIds = [1, 2, 3]; // Remplacez par les IDs des utilisateurs tagués
$comment->taggedUsers()->attach($taggedUserIds);
Assurez-vous de remplacer $commentId par l'ID réel du commentaire et $taggedUserIds par un tableau contenant les IDs des utilisateurs que vous souhaitez taguer.

Pour récupérer les utilisateurs tagués d'un commentaire donné, vous pouvez utiliser la relation taggedUsers() définie dans le modèle Comment. Par exemple :
php
Copy code
$comment = Comment::find($commentId);
$taggedUsers = $comment->taggedUsers;
Cela vous donnera une collection des utilisateurs tagués pour le commentaire spécifié.

De même, pour récupérer les commentaires tagués par un utilisateur donné, vous pouvez utiliser la relation taggedComments() définie dans le modèle User. Par exemple :
php
Copy code
$user = User::find($userId);
$taggedComments = $user->taggedComments;
Cela vous donnera une collection des commentaires où l'utilisateur est tagué.

C'est ainsi que vous pouvez mettre en place un système de tag en utilisant des relations many-to-many dans Laravel. Vous pouvez ensuite utiliser ces relations pour afficher les utilisateurs tagués sur les commentaires et pour effectuer d'autres opérations en fonction de vos besoins spécifiques.

*/