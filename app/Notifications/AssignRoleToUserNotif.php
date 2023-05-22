<?php

namespace App\Notifications;

use App\Models\Task;
use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AssignRoleToUserNotif extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Group $group, protected User $user, protected Task $task)
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
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'type' => 1,
            'object' => 'Nouvelle tache vous est confiée dans le groupe ' . Str::substr($this->group->name, 0, 35) . '...'
        ];
    }
}
