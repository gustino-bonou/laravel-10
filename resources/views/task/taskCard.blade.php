
<?php
  $route = request()->route()->getName();
?>
<div class="">
    <div class="row row-cols-1 row-cols-md-3 g-4">
      @forelse ($tasks as $task)
          <div class="col">
            <div class="card">
              <div class="card-body">
                <h5 class="">  
                  @if ($route == 'taches.terminees') Date fin: {{ $task->getDate($task->finished_at)}}
                  @elseif ($route == 'taches.en_cours') Date démarrage: {{ $task->getDate($task->beginned_at)}}
                  @elseif ($route == 'taches.a_venir') Démarre le: {{ $task->getDate($task->begin_at)}}
                  @else
                  Démarre normalement: {{ $task->getDate($task->begin_at)}}
                  @endif 
                </h5>
                <p class="card-text ">{{ $task->description }}</p>
                <div class="d-flex  justify-content-between ">
                    <p class="card-text">
                      <small class="text-muted">
                      @if ($route == 'taches.terminees') Date Démarrage:  {{ $task->getDate($task->beginned_at)}}
                      @elseif ($route == 'taches.en_cours') A terminer avant:  {{ $task->getDate($task->finish_at)}}
                      @elseif ($route == 'taches.a_venir') Termine le:   {{ $task->getDate($task->finish_at)}}
                      @else
                      Finie normalement:  {{ $task->getDate($task->finish_at)}}
                      @endif
                    </small>
                   </p>
                    <p class="card-text"><h6 class=" border-light text-bold">{{ Str::ucfirst($task->level)}} </h6></p>
                </div>
                
                <div class="d-flex align-items-center justify-content-md-start gap-2 card-footer">
                  
                    <a href="{{ route('taches.edit', ['task' => $task->id ]) }}" class="btn btn-primary btn-sm">Editer</a>
                    {{-- Pour vérifier si l'utilisateur a le droit avant d'afficher le bouton --}}

                      <form action="{{ route('taches.destroy', $task->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm">Supprimer</button>
                      </form>
                      

                      @if ($route == 'taches.a_venir')
                      <form action="{{ route('taches.marque.begin', $task->id) }}" method="post">
                        @csrf
                        @method('put')
                        <button class="btn btn-success btn-sm">Demarrer</button>
                      </form>
                      @endif
                        
                      @if ($route == 'taches.en_cours')
                      <form action="{{ route('taches.marque.finish', $task->id) }}" method="post">
                        @csrf
                        @method('put')
                        <button class="btn btn-success btn-sm">MCT</button>
                      </form>
                      @endif
                        
                </div>
              </div>
            </div>
          </div>
      @empty
          
      @endforelse
      
    </div>
  </div>