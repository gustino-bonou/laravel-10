@extends('base')

@section('title')
    Home
@endsection

@section('content')

<div class=" text-center my-5">
    <h3 class="text-info"> Ces taches terminent bientot</h3>
</div>

<div>
    <table class="table table.striped">
        <thead>
            <tr>
                <th>Tache</th>
                <th>Date de démarrage</th>
                <th>Terminer le </th>
                <th>Niveau</th>
                <th class="text-end">Actions</th>
    
            </tr>
        </thead>
        <tbody>
    
            @forelse ($taches as $tache)
                <tr>
                    
                    <td>{{ $tache->name }}</td>
                    <td>{{  $tache->getDate($tache->begin_at) }}</td>
                    <td>{{ $tache->getDate($tache->finish_at)  }}</td>
                    <td class="font-weight-bold @if($tache->level == 'low') text-secondary  @elseif($tache->level == 'high') text-danger @elseif($tache->level == 'medium') text-warning @endif">
                        {{ Str::ucfirst($tache->level) }}</td>
                    <td>
                        <div class="d-flex gap-2 w-100 justify-content-end">
                            {{-- Pour vérifier si l'utilisateur a le droit avant d'afficher le bouton --}}
    
                            <a href="{{ route('taches.edit', ['tach' => $tache->id ]) }}" class="btn btn-primary">Détails</a>
    
                              <form action="{{ route('taches.destroy', $tache->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger">Supprimer</button>
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
</div>

   
@endsection