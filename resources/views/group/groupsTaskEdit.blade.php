@if ($tache->group_id !== null)


<div class="d-flex gap-2 w-100  justify-content-between align-content-between card-footer  mb-3"> 

    <h4>Cette tache est confiée aux utilisateurs suivants:</h4>
    <a href="{{ route('group.view.assign.rol', ['group' => $tache->group_id, 'task' => $tache->id]) }}" class="btn btn-secondary">Ajouter d'utilisateur</a>
  
</div>

    <div class="mb-5">
        <table class="table table.striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    
                    <th><div class="d-flex gap-2 w-100 justify-content-end">Action</div></th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                    @forelse ($tache->users as $user)
                            <td>{{ $user->name}}</td>
                            <td>{{ $user->email}}</td>  
                            <td>
                                <div class="d-flex gap-2 w-100 justify-content-end">                
                                    <a href="{{ route('group.detach.rol', ['task' => $tache->id, 'user' => $user->id])}}" class="btn btn-warning btn-sm">Retirer de la tache</a>                                    
                                </div>
                            </td>
                </tr>
                    
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
    
@endif