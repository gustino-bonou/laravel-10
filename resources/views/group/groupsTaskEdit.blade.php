@if ($tache->group_id !== null)

   <div class="mb-3">
    Cette tache est confiée aux utilisateurs suivants:
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