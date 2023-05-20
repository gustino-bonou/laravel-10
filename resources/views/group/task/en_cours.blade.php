@extends('base')

@section('title')
    Taches en cours
    
@endsection

@section('content')

<div class=" text-center my-5">
    <h3 class="text-info">Vos taches en cours</h3>
</div>

<table class="table table.striped">
    <thead>
        <tr>
            <th>Tache</th>
            <th>Démarrée le </th>
            <th>Deadline</th>
            <th>Niveau</th>

            <th class="text-end">Actions</th>

        </tr>
    </thead>
    <tbody>

        @forelse ($tasks as $task)
            <tr>
                
                <td>{{ $task->name }}</td>
                <td>{{$task->getDate($task->begin_at)}}</td>
                <td>{{ $task->getDate($task->finish_at) }}</td>
                <td class="font-weight-bold @if($task->level == 'low') text-secondary  @elseif($task->level == 'high') text-danger @elseif($tache->level == 'medium') text-warning @endif">{{ Str::ucfirst($tache->level) }}</td>
                <td>
                    <div class="d-flex gap-2 w-100 justify-content-end">
                        <a href="{{ route('task.edit', ['task' => $task->id ]) }}" class="btn btn-primary m-1 btn-sm">Editer</a>
                        {{-- Pour vérifier si l'utilisateur a le droit avant d'afficher le bouton --}}

                          <form action="{{ route('task.destroy', $task->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger m-1 btn-sm">Supprimer</button>
                            </form>
                          <form action="{{ route('task.marque.finish', $task->id) }}" method="post">
                                @csrf
                                @method('put')
                                <button class="btn btn-success m-1 btn-sm">MCT</button>
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

{{ $tasks->links() }}
    
@endsection