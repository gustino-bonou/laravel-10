<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use App\Mail\InviteUserToJoinGroupMail;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InviteUserToJoinGroupNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Group $group, protected User $user)
    {
        
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
    public function toMail(object $notifiable): InviteUserToJoinGroupMail
    {
        return (new InviteUserToJoinGroupMail($this->group, $this->user));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'object' => "Une nouvelle invitation de rejoindre un group ... ",
            'group' => $this->group->id,
            'type' => 'invitation'
        ];
    }
}
