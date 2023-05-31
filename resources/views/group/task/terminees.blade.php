@extends('base')

@section('title')
    Taches terminées
    
@endsection

@section('content')

<div class=" text-center my-5">
    <h3 class="text-info">{{$group->name }}Taches terminées</h3>
</div>


<table class="table table.striped">
    <thead>
        <tr class="link-clicked-group">
            <th>Tache</th>
            <th>Démarrée le  </th>
            <th>Terminée le</th>
            <th>Niveau</th>
            <th class="text-end">Actions</th>

        </tr>
    </thead>
    <tbody>

        @forelse ($tasks as $task)
            <tr>
                
                <td>{{ $task->name }}</td>
                <td>{{ $task->getDate($task->beginned_at) }}</td>
                <td>{{ $task->getDate($task->finished_at) }}</td>
                <td class="font-weight-bold @if($task->level == 'low') text-secondary  @elseif($task->level == 'high') text-danger @elseif($task->level == 'medium') text-warning @endif">
                    {{ Str::ucfirst($task->level) }}</td>
                <td>
                    <div class="d-flex gap-2 w-100 justify-content-end">
                        {{-- Pour vérifier si l'utilisateur a le droit avant d'afficher le bouton --}}

                        @can('update', $task)
                            <a href="{{ route('task.edit', ['task' => $task->id ]) }}" class="btn btn-primary m-1 btn-sm">Détails</a>

                            @can('updateGroupTask')
                                <form action="{{ route('task.destroy', $task->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger m-1 btn-sm">Supprimer</button>
                                </form>
                            @endcan
                         @endcan

                            
                    </div>
                </td>
            </tr>
        @empty
        <div class="text-center m-5">
            Aucune tache terminée pour le moment.
        </div>
        @endforelse

    </tbody>
</table>

{{ $tasks->links() }}
    
@endsection