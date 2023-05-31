

@if ($tache->group_id !== null)
<div class="m-3">
    <div class="mb-5">
        <div class="mt-4 mb-4">
            <h5>Auteur de la tache: {{$tache->user->name}}</h5>
        </div>
        <form action="{{ route('group.task.comment.store', ['group' => $tache->group, 'task' => $tache->id])}}" method="post">
            @csrf
            @method('post')
            <div class="d-flex gap-5 w-100  justify-content-between align-content-between mb-3">
                <input type="text" placeholder="comment this task" name="content" class="form-control" value="">
                <button class="btn btn-primary flex-grow-0">
                    Commenter
                </button>
            </div>
        </form>
    </div>

    {{-- Build comments --}}
    @if ($taskComments !== null)
    <div class=" mb-5">
        @forelse ($taskComments as $comment)
        <div class="gap-2 w-100 ">
            <h6>{{$comment->user->name}}</h6>
            <p>
                {{ $comment->content }}
            </p>
        </div>
        @empty
            
        @endforelse

        {{$taskComments->links()}}
    </div>
    @endif

   
        <div class="d-flex gap-2 w-100  justify-content-between align-content-between card-footer  mb-3"> 
        
            <h4>Cette tache est confiée aux utilisateurs suivants:</h4>
            @can('assinRolToUser', $tache->group)
                <a href="{{ route('group.view.assign.rol', ['group' => $tache->group_id, 'task' => $tache->id]) }}" class="btn btn-secondary">Ajouter d'utilisateur à cette tache</a>
            @endcan

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
                                    @can('detachUserOnTask', $tache->group)
                                        <div class="d-flex gap-2 w-100 justify-content-end">                
                                            <a href="{{ route('group.detach.rol', ['task' => $tache->id, 'user' => $user->id])}}" class="btn btn-warning btn-sm">Retirer de la tache</a>                                    
                                        </div>
                                    @endcan
                                </td>
                    </tr>
                        
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
</div>
    
@endif