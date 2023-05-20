<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Group;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Mail\AssignedTaskToUserInGroupMail;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AssignedTaskToUserInGroupNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Group $group, public User $user, public Task $task)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): AssignedTaskToUserInGroupMail
    {
        return (new AssignedTaskToUserInGroupMail($this->group, $this->user, $this->task));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            
            'task_id' => $this->task->id,
            'group_id' => $this->group->id,
        ];
    }
}
