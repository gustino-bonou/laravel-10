@extends('base')

@section('title')
    Taches en cours
    
@endsection

@section('content')

<div class=" text-center my-5">
    <h3 class="text-info">Vos taches non démarrées</h3>
</div>

<table class="table table.striped">
    <thead>
        <tr class="link-clicked-group">
            <th>Tache</th>
            <th>Démarrage </th>
            <th>Deadline</th>
            <th>Niveau</th>
            <th class="text-end">Actions</th>

        </tr>
    </thead>
    <tbody>

        @forelse ($tasks as $task)
            <tr>
                
                <td>{{ $task->name }}</td>
                <td>{{ $task->getDate($task->begin_at) }}</td>
                <td>{{ $task->getDate($task->finish_at)}}</td>
                <td class="font-weight-bold @if($task->level == 'low') text-secondary  @elseif($task->level == 'high') text-danger @elseif($task->level == 'medium') text-warning @endif">{{ Str::ucfirst($task->level) }}</td>
                <td>
                    <div class="d-flex gap-3  justify-content-end">

                        <a href="{{ route('task.edit', ['task' => $task->id ]) }}" class="btn btn-primary btn-sm m-1">Editer</a>
                        {{-- Pour vérifier si l'utilisateur a le droit avant d'afficher le bouton --}}

                            <form action="{{ route('task.destroy', $task->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger m-1 btn-sm">Supprimer</button>
                            </form>
                            <a href="{{ route('task.marque.begin', $task->id) }}" class="btn  btn-info m-1 btn-sm">Démarrer</a>
                          
                    </div>
                </td>
            </tr>
        @empty
        <div>
            
        </div>
        @endforelse

    </tbody>
</table>

{{ $tasks->links() }}
    
@endsection