{{-- 






<table class="table table.striped">
    <thead>
        <tr >
            <th>Tache</th>
            <th>Niveau</th>
            <th>Etat</th>
            <th class="text-end">Actions</th>
        </tr>
    </thead>
    <tbody>

            <tr>

                @forelse ($group->tasks as $task)

                
                
                <td>{{ $task->name }}</td>

                <td class="font-weight-bold @if($task->level == 'low') text-secondary  @elseif($task->level == 'high') text-danger @elseif($task->level == 'medium') text-warning @endif">
                    {{ Str::ucfirst($task->level) }}</td>
                <td>{{ $task->getTaskStatus() }}</td>
                <td>
                    <div class="d-flex gap-2 w-100 justify-content-end">                
                        <a href="{{ route('task.edit', ['group' => $group, 'task' => $task]) }}" class="btn btn-primary">Détails</a>

                        <a href="{{ route('group.view.assign.rol', ['group' => $group->id, 'task' => $task->id]) }}" class="btn btn-secondary">Fonfier à</a>

                          <form action="{{ route('task.destroy', $task) }}" method="post">
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
 --}}


@extends('base')

@section('title', $group->id == null ? 'Créer un group' : 'Modifier un groupe')
    

@section('content')



<div class="m-4">

    @include('group.sectionMenuMembersWorkSpace')
    
    <div class="m-4">
        <div class="text-center mb-5">
            <div class="d-flex gap-2 w-100  justify-content-between align-content-between mb-3">
                <h5>Cest taches sont celles à écheances les plus proches</h5>
                <a href="{{ route('task.create', ['group' => $group->id]) }}" class=""> Créer une tache </a>
            </div>
            
            <div class="row">
                @forelse ($homeTasks as $task)
                <div class="col-sm-4">
                    <div class="card mb-3">
                      <div class="card-body">
                        <h5 class="card-title">Deadline: {{ $task->getDate($task->finish_at) }}</h5>
                        <p class="card-text">{{ $task->name }}</p>
                        <p class="card-text">{{ $task->description }}</p>
                        <p class="card-text">Démarrage: {{ $task->getDate($task->begin_at) }}</p>
                        <!-- Autres informations de la tâche -->
                        <div class="d-flex gap-2 w-100  justify-content-between align-content-between card-footer">                
                            <a href="{{ route('task.edit', ['group' => $group, 'task' => $task]) }}" class="btn btn-primary btn-sm">Détails</a>
                                
                              <form action="{{ route('task.destroy', $task) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm">Supprimer</button>
                             </form>    
                        </div>
                      </div>
                    </div>
                </div>
                @empty
                    <div class="container my-5">
                        <p>Hoppp ! Vous n'estes pas sous pression. Ajouter une tache  
                            <a href="{{ route('task.create', ['group' => $group->id]) }}" class=""> ici </a>
                        </p>
                    </div>
                @endforelse
            </div>


        </div>

        <div class=" mb-5">
            <div class="d-flex p-2 bd-highlight justify-between">
                <h5>Les membres</h5>
            </div>
            <div>
                <table class="table table.striped">
                    <thead>
                        <tr>

                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            @forelse ($group->users as $user)
                            <td>{{ $user->name}}</td>
                            <td>{{ $user->email}}</td>  
                            <td>
                                <div class="d-flex gap-2 w-100 justify-content-end">                
            
                                      <form action="" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn  btn-warning">Retirer</button>
                                     </form>
            
                                        
                                </div>
                            </td>
                        </tr>
                            
                        @empty
                            
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mb-5">

            <p class="text-start">
                Rechercehr d'utilisateur pour en ajouter
            </p>
    
            <form action="" method="get" class="container d-flex gap-2">
                <input type="text" placeholder="Search users" name="name" class="form-control" value="{{ $input['name'] ?? ''}}">
                <button class="btn btn-primary flex-grow-0">
                    Rechercher
                </button>
            </form>
    
            <div>
                <table class="table table.striped">
                    <thead>
                        <tr>
    
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            @forelse ($allUsers as $user)
                            <td>{{ $user->name}}</td>
    
                            <td>
                                <div class="d-flex gap-2 w-100 justify-content-end">
                                    @if ($group->users->contains($user))
                                        <h5 class="btn btn-success btn-sm">Membre</h4>
                                    @else
                                        <a href="{{ route('group.invite.user', ['group' => $group->id, 'user' => $user->id])}}" class=" btn btn-secondary btn-sm">Inviter  </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                            
                        @empty
                            
                        @endforelse
                    </tbody>
                </table>

                {{ $allUsers->links() }}
            
            </div>
        
        </div>
    </div>
   
</div>
      
@endsection









