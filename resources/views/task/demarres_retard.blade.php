@extends('base')

@section('title')
    Taches démarrées avec retdar
    
@endsection

@section('content')

<div class=" text-center my-3 d-flex gap-4 w-100  align-content-center align-items-center  justify-content-between">
    <h5 class="text-info">@yield('title')</h5>

    <a href="{{ route('home') }}">Menu stats</a>
</div>

<table class="table table.striped">
    <thead>
        <tr class="table-entete">
            <th>Tache</th>
            <th>Devait démarrée le  </th>
            <th>Démarrée le</th>
            <th>Niveau</th>
            <th>Retard</th>
            <th class="text-end">Actions</th>

        </tr>
    </thead>
    <tbody>

        @forelse ($tasks as $task)
            <tr>
                
                <td>{{ $task->name }}</td>
                <td>{{ $task->getDate($task->begin_at) }}</td>
                <td>{{ $task->getDate($task->beginned_at) }}</td>
                <td class="font-weight-bold @if($task->level == 'low') text-secondary  @elseif($task->level == 'high') text-danger @elseif($task->level == 'medium') text-warning @endif">
                    {{ Str::ucfirst($task->level) }}
                </td>
                <td class="font-weight-bold">
                    {{ $task->getDiffInDates(htmlspecialchars($task->beginned_at), htmlspecialchars($task->begin_at)) }}</td>
                </td>

                <td>

                    <div class="d-flex gap-2 w-100 justify-content-end">

                        <a href="{{ route('task.edit', ['task' => $task->id ]) }}" class="btn btn-primary m-1 btn-sm">Détails</a>

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
            <span class="not-task-info">Aucune tache démarrée en retard</span>
        </div>
        @endforelse

    </tbody>
</table>

    
@endsection