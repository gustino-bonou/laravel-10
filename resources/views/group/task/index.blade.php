@extends('base')
@section('title')
    Mes taches
@endsection
<?php
$route = request()->route()->getName();
?>
@section('content')


<?php
    $route = request()->route()->getName();
?>

<div class=" text-center my-5">
    <h3 class="text-info">Toutes vos taches</h3>
</div>

<table class="table table.striped">
    <thead>
        <tr>
            <th>Tache</th>
            <th>Demarrage</th>
            <th>Deadline</th>
            <th>Niveau</th>
            <th class="text-end">Actions</th>

        </tr>
    </thead>
    <tbody>
task
        @forelse ($tasks as $task)
            <tr>
                
                <td>{{ $task->name }}</td>
                <td>{{ $task->getDate($task->begin_at)}}</td>
                <td>{{ $task->getDate($task->finish_at) }}</td>
                <td class="font-weight-bold @if($task->level == 'low') text-secondary  @elseif($task->level == 'high') text-danger @elseif($task->level == 'medium') text-warning @endif">{{ Str::ucfirst($task->level) }}</td>
                <td>
                    <div class="d-flex gap-4 w-100 justify-content-end">

                        <a href="{{ route('task.edit', ['task' => $task->id ]) }}" class="btn btn-primary m-1 btn-sm">Editer</a>
                        
                        {{-- Pour vérifier si l'utilisateur a le droit avant d'afficher le bouton --}}

                          <form action="{{ route('task.destroy', $task->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger m-1 btn-sm">Supprimer</button>
                            </form>

                            
                    </div>
                </td>
            </tr>
        @empty
        <div>
            
        </div>
        @endforelse

    </tbody>
</table>


<div>
    {{ $tasks->links() }}
</div>


@endsection('content')



