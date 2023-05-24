<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\TacheEcheanceNotification;
use App\Notifications\TaskEcheanceProcheNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class TaskEchanceProcheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:task-echance-proche-command';

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

        foreach ($users as $user)
        {
            foreach ($user->tasks as $task)
            {
                $finish_at = $task->parseDateInCarbon($task->finish_at);

                if($finish_at < Carbon::now()->addDays(3))
                {
                    $user->notify(new TacheEcheanceNotification($task, $user));
                }
            }
        }
    }
}
