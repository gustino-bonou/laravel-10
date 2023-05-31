@extends('base')

@section('title')
    Taches en cours
    
@endsection

@section('content')

<div class="">
    
<div class=" text-center my-3 d-flex gap-4 w-100  align-content-center align-items-center  justify-content-between">
    <h5 class="text-info">Vos taches non démarrées</h5>

    <a href="{{ route('home') }}">Menu stats</a>
</div>

<table class="table table.striped">
    <thead>
        <tr class="table-entete">
            <th class="">Tache</th>
            <th>Démarrage </th>
            <th>Deadline</th>
            <th>Niveau</th>
            <th class="text-end">Actions</th>

        </tr>
    </thead>
    <tbody>

        @forelse ($taches as $tache)

            <tr class="">
                
                <td>{{ $tache->name }}</td>
                <td>{{ $tache->getDate($tache->begin_at) }}</td>
                <td>{{ $tache->getDate($tache->finish_at)}}</td>
                <td class="font-weight-bold @if($tache->level == 'low') text-secondary  @elseif($tache->level == 'high') text-danger @elseif($tache->level == 'medium') text-warning @endif">{{ Str::ucfirst($tache->level) }}</td>
                <td>
                    <div class="d-flex gap-3  justify-content-end">

                        <a href="{{ route('task.edit', ['task' => $tache->id ]) }}" class="btn btn-primary btn-sm m-1">Editer</a>
                        {{-- Pour vérifier si l'utilisateur a le droit avant d'afficher le bouton --}}

                            <form action="{{ route('task.destroy', $tache->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger m-1 btn-sm">Supprimer</button>
                            </form>

                            <a href="{{ route('task.marque.begin', $tache->id) }}" class="btn  btn-info m-1 btn-sm">Démarrer</a>
                          
                    </div>
                </td>
            </tr>
        @empty
        <div class=" ">
            <h5 class="not-task-info">Aucune tache non démarrée</h5>
        </div>
        @endforelse

    </tbody>
</table>

{{ $taches->links() }}
</div>

@endsection