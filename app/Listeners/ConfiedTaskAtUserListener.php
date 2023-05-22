<?php

namespace App\Listeners;

use App\Events\SendNotificationToUserConfiedTaskInGroupEvent;
use App\Notifications\AssignedTaskToUserInGroupNotification;
use App\Notifications\AssignRoleToUserNotif;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ConfiedTaskAtUserListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendNotificationToUserConfiedTaskInGroupEvent $event): void
    {
        $event->user->notify(new AssignRoleToUserNotif($event->group, $event->user, $event->task));
    }
}
