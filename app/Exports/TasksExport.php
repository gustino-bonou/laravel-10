<?php

namespace App\Exports;


use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class TasksExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(public $data)
    {

    }
    
    public function view(): View
    {
        return view('export.task.tasks_excel', [
            'tache' => $this->data
        ]);
    }
}
