@extends('base')

@section('title')
    Taches terminées
    
@endsection

@section('content')

<div class=" text-center my-5">
    <h3 class="text-info">Vos taches terminées</h3>
</div>


<table class="table table.striped">
    <thead>
        <tr>
            <th>Tache</th>
            <th>Démarrée le  </th>
            <th>Terminée le</th>
            <th>Niveau</th>
            <th class="text-end">Actions</th>

        </tr>
    </thead>
    <tbody>

        @forelse ($taches as $tache)
            <tr>
                
                <td>{{ $tache->name }}</td>
                <td>{{ $tache->getDate($tache->beginned_at) }}</td>
                <td>{{ $tache->getDate($tache->finished_at) }}</td>
                <td class="font-weight-bold @if($tache->level == 'low') text-secondary  @elseif($tache->level == 'high') text-danger @elseif($tache->level == 'medium') text-warning @endif">
                    {{ Str::ucfirst($tache->level) }}</td>
                <td>
                    <div class="d-flex gap-2 w-100 justify-content-end">
                        {{-- Pour vérifier si l'utilisateur a le droit avant d'afficher le bouton --}}

                        <a href="{{ route('task.edit', ['task' => $tache->id ]) }}" class="btn btn-primary m-1 btn-sm">Détails</a>

                          <form action="{{ route('task.destroy', $tache->id) }}" method="post">
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

{{ $taches->links() }}
    
@endsection