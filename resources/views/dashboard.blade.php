@extends('base')

@section('title')
    Dashboard
@endsection


@section('content')
<?php
      $route = request()->route()->getName();
      ?>

  <div class="container">

        <div class="d-flex justify-content-between">
          <a href="{{ route('group.index') }}">Mes groupes</a>
          <a href="{{ route('group.im.member') }}">Groupes dont je suis membres</a>
          <a href="{{ route('task.create') }}">Créer une tache</a>
        </div>

        <div class="row table-stats text-centent justify-content-center">

            <div class="col text-center">
              <a href="{{ route('task.index') }}" class="table-entete">Nrb Total Taches</a>
              <h5 class="mt-2">{{ $nbrTotalTaches }}</h5>
            </div>
          
            <div class="col text-center">
              <a href="{{ route('task.a_venir') }}" class="table-entete">Taches non démarrées</a>
              <h5 class="mt-2">{{ $nrbTachesNondemarrees }}</h5>
            </div>
          
 
          <div class="col text-center">
            <a href="{{ route('task.demarree.retard') }}" class="table-entete">Taches démarrées avec retard</a>
              <h5 class="">{{ $nbrTachesDemarreesEnRetard }}</h5>
          </div>

          <div class="col text-center">
            <a href="{{ route('task.terminees') }}" class="table-entete">Taches terminées</a>
              <h5 class="">{{ $nbrTachesTerminees }}</h5>
          </div>

          <div class="col text-center">
            <a href="{{ route('task.retard') }}" class="table-entete">Taches terminées avec retard</a>
              <h5 class="">{{ $nbrTachesTermineesEnRetard }}</h5>
          </div>
          <div class="col text-center">
            <a href="{{ route('task.en_cours') }}" class="table-entete">Taches  en cours</a>
              <h5 class="">{{ $nbrTachesEnCours }}</h5>
          </div>

        </div>



        <div>
          <h5 class="info-echeance"> Ces sont à écheance plus proche</h5>
        </div>


        <div class=" text-center">
          <div class="row">
            @forelse ($tasksEcheanceProches as $task)
            @can('view', $task)
            <div class="col-sm-4">
                <div class="card mb-3">
                  <div class="card-body">
                    <h5 class="card-title">Deadline: {{ $task->getDate($task->finish_at) }}</h5>
                    <p class="card-text">{{ $task->name }}</p>
                    <div class="d-flex gap-2 w-100  justify-content-between align-content-between ">    
                        
                        <p class="card-text">Démarrage: {{ $task->getDate($task->begin_at) }}</p>
                        
                        <p>{{$task->getTaskStatus()}}</p>
                            
                    </div>
                    
                    <div class="d-flex gap-2 w-100  justify-content-between align-content-between card-footer">                
                        <a href="{{ route('task.edit', ['task' => $task]) }}" class="btn btn-primary btn-sm">Détails</a>
                            
                          <form action="{{ route('task.destroy', $task) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm">Supprimer</button>
                         </form>    
                    </div>
                  </div>
                </div>
            </div>
            @endcan
            @empty
                <div class="text-center my-5">
                    <p>Hoppp ! Vous n'estes pas sous pression. Ajouter une tache  
                        <a href="{{ route('task.create') }}" class=""> ici </a>
                    </p>
                </div>
            @endforelse
          </div>
        </div>



        
  </div>

@endsection