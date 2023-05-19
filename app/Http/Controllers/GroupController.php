<?php

namespace App\Http\Controllers;

use App\Events\SendNotificationToUserConfiedTaskInGroupEvent;
use App\Http\Requests\AssignRoleToUserRequest;
use App\Http\Requests\GroupRequest;
use App\Http\Requests\SearchUserRequest;
use App\Models\Group;
use App\Models\Task;
use App\Models\User;
use App\Notifications\AssignRoleToUserNotif;
use App\Notifications\InviteUserToJoinGroupNotification;
use Auth;
use Illuminate\Http\Request;
use Mail;
use Notification;
use PhpParser\Node\Stmt\Return_;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $user = User::find(Auth::id());

        $groups = $user->groupsWhenImAuthor()->paginate(8);

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


        $query = User::query()->orderBy('name');

        if($request->validated('name'))
        {
            $query = $query->where('name', 'like', "%{$request->validated('name')}%");
        }

        return view('group.workspace', [

            'group' => $group,
            'allUsers' => $query->paginate(15),
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

            Notification::route('database', new AssignRoleToUserNotif($group, $user, $task));

            

            //Mail::to('')->send(new monMAil)

            //Notification::send([''], new Notification)

            //event(new SendNotificationToUserConfiedTaskInGroupEvent($group, $user, $task));

        }

        dd('ok');

        

        return to_route('group.workspace', [
            'group' => $task->group_id
        ])->with('success', 'Tache bien confiée');
    }
    public function detachUserOnGroupTask($task, $user)
    {


        $task = Task::findOrFail($task);

        $task->users()->detach($user);

        return back();
    }
}
