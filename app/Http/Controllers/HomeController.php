<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Task;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Notification;

class HomeController extends Controller
{
    public function myNotifications()
    {
        $user = User::find(Auth::id());

        $myNotifications = $user->notifications()->orderBy('created_at', 'asc')->get();

        $notifData = [];

        foreach($myNotifications as $myNotification)
        {
            $task = null;
            $group = null;
        
            if(array_key_exists('task_id', $myNotification->data))
            {
                $task = Task::find($myNotification->data['task_id']);
            }
            if(array_key_exists('group_id', $myNotification->data))
            {
                $group = Group::find($myNotification->data['group_id']);
            } 

            $object = $myNotification->data['object'];

            $notifData[] = [
                'task' => $task,
                'group' => $group,
                'object' => $object,
                'type' => $myNotification->data['type']
            ];

        }

        return view('notification.my_notifications', [
            'notifications' => $notifData
        ]);
    }
    public function notificationDetail(DatabaseNotification $notification)
    {

        return view('groupn', [
            'notification' => $notification
        ]);
    }
}
