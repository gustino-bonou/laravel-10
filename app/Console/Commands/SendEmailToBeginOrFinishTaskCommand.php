<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\User;
use App\Notifications\BeginnedTaskNotification;
use App\Notifications\FinishTaskNotification;
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
                    if($task->notifiable === 1)
                    {
                        $user->notify(new BeginnedTaskNotification($task, $user));
                    }
                    
                }
                elseif($finish->isSameDay(now()) && $task->finished_at === null )
                {
                    if($task->notifiable === 1)
                    {
                        $user->notify(new FinishTaskNotification($task, $user));
                    }
                }  
                
             
            }
        }        
        
        
    }
}
