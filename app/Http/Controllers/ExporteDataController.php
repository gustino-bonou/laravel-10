<?php

namespace App\Http\Controllers;

use App\Exports\TasksExport;
use App\Models\Task;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ExporteDataController extends Controller
{
    public function export($task, $type)
    {

        $task = Task::find($task);

        if($type === 'pdf')
        {
            $pdf = Pdf::loadView('export.task.tasks', [
                'tache' => $task
            ]);

            return $pdf->download('tasks.pdf');
        }

        elseif($type === 'xlsx')
        {
            return Excel::download(new TasksExport($task), 'tasks.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        }

        else
        {
            return Excel::download(new TasksExport($task), 'tasks.csv', \Maatwebsite\Excel\Excel::CSV);
        } 
        
        
    }
}
