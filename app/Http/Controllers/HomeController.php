<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Task;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\DatabaseNotification;

class HomeController extends Controller
{
    public function myNotifications()
    {

    }

    public function notificationDetail(DatabaseNotification $notification)
    {

        return view('groupn', [
            'notification' => $notification
        ]);
    }

    public function allNotificaions()
    {
        $user = Auth::user();

        $notifs = DB::table('notifications')->where('notifiable_id', $user->id)->orderBy('created_at', 'asc')->get();

        $tableNotifs = [];

        foreach($notifs as $notif)
        {
            $data = json_decode($notif->data);
            if($data->type === 'begin' || $data->type === 'finish' || $data->type === 'echeance')
            {
                $tableNotifs[] = [
                    'object' => $data->object,
                    'type' => $data->type,
                    'task' => Task::findOrFail($data->task)
                ];
            }
            elseif($data->type === 'tacheAssignee' )
            {
                $tableNotifs[] = [
                    'object' => $data->object,
                    'type' => $data->type,
                    'task' => Task::findOrFail($data->task),
                    "group" => Group::findOrFail($data->group)
                ];
            }
            elseif ( $data->type === 'invitation')
            {
                $tableNotifs[] = [
                    'object' => $data->object,
                    'type' => $data->type,
                    "group" => Group::findOrFail($data->group)
                ];
            }
        }


        $beginTasknotifications = DB::table('notifications')
            ->where('data->type', 'begin')
            ->where('notifiable_id', $user->id)
            ->get();


        $taskBeginned = [];

        foreach ($beginTasknotifications as $notification) {
            $data = json_decode($notification->data);
            $task = Task::findOrFail($data->task);

            $taskBeginned[] = $task;
        }
    




        $finishTasknotifications = DB::table('notifications')
            ->where('data->type', 'finish')
            ->where('notifiable_id', $user->id)
            ->get();
            $taskFinished = [];
            foreach ($finishTasknotifications as $notification) {
                $data = json_decode($notification->data);
                $task = Task::findOrFail($data->task);
    
                $taskFinished[] = $task;
            }


        $echeanceTasknotifications = DB::table('notifications')
            ->where('data->type', 'echeance')
            ->where('notifiable_id', $user->id)
            ->get();
            $taskEcheances = [];
            foreach ($echeanceTasknotifications as $notification) {
                $data = json_decode($notification->data);
                $task = Task::findOrFail($data->task);
    
                $taskEcheances[] = $task;
            }


        $tacheAssigneesTasknotifications = DB::table('notifications')
            ->where('data->type', 'tacheAssignee')
            ->where('notifiable_id', Auth::id())
            ->get();

            $assignTasks = [];
            foreach ($tacheAssigneesTasknotifications as $notification) {
                $data = json_decode($notification->data);
                $task = Task::findOrFail($data->task);
                $group = Group::findOrFail($data->group);
    
                $assignTasks[] = [
                    'task' => $task,
                    'group' => $group
                ];
            }


        $invitationGroupNotifications = DB::table('notifications')
            ->where('data->type', 'invitation')
            ->where('notifiable_id', Auth::id())
            ->get();

            $invitationsGroup = [];
            foreach ($invitationGroupNotifications as $notification) {


                $data = json_decode($notification->data);

                $group = Group::findOrFail($data->group);
    
                $invitationsGroup[] = $group ;
            }

            $user = Auth::user();
            $notifications = $user->notifications()->get();
            
            foreach ($notifications as $notification) {
                $notification->markAsRead();
            }

            return view('notification.my_notifications', [

                'taskBeginned' => $taskBeginned,

                'taskFinished' => $taskFinished,

                'taskEcheances' => $taskEcheances,

                'assignTasks' => $assignTasks,

                'invitationsGroup' => $invitationsGroup,

                'tableNotifs' => $tableNotifs
            ]);

           
    }
}
