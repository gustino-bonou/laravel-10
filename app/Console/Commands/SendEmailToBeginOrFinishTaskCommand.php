<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\User;
use App\Notifications\MarqueBeginnedOrFinishedTaskNotification;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

class SendEmailToBeginOrFinishTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:begin-or-finish-task-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        
        foreach($users as $user)
        {

            foreach($user->tasks as $task)
            {
                $begin = Carbon::parse($task->begin_at);
                $finish = Carbon::parse($task->finish_at);

                if( $begin->isSameDay(now()) && $task->beginned_at === null )
                {
                    $user->notify(new MarqueBeginnedOrFinishedTaskNotification($task, $user));
                    if($task->notififiable)
                    {
                        $user->notify(new MarqueBeginnedOrFinishedTaskNotification($task, $user));
                    }
                    
                }

                if($finish->isSameDay(now()) && $task->finished_at === null && $task->beginned_at !== null)
                {
                    if($task->notififiable)
                    {
                        $user->notify(new MarqueBeginnedOrFinishedTaskNotification($task, $user));
                    }
                }  
                
             
            }
        }        
        
        
    }
}
