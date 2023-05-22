@extends('base')

@section('title')
    Dashboard
@endsection


@section('content')
<?php
      $route = request()->route()->getName();
      ?>
  <div class="container-fluid my-3">

    <div class="row align-items-center align-content-between justify-center">

      {{-- La colonne des menus --}}
      <div class="col-md-3 mt-3">
        <!-- Sidebar -->
          <div class="">
            
            <ul class="nav flex-column">
              <li class="nav-item mb-3">
                  <a href="{{ route('task.create') }}" class="@if ($route == 'task.create')
                  text-dark
              @endif">Créer une tache</a>
              </li>

              <li class="nav-item mb-3">
                  <a href="{{ route('task.index') }}" class="@if ($route == 'task.index')
                  text-dark
              @endif">Toutes mes taches</a>
              </li>
              
              <li class="nav-item mb-3">
                <a href="{{ route('task.terminees') }}" class="@if ($route == 'task.terminees')
              text-dark
              @endif">Taches  Terminées</a>
          
              </li>
              <li class="nav-item mb-3">
                <a href="{{ route('task.en_cours') }}" class="@if ($route == 'task.en_cours')
              text-dark
              @endif">Taches  en cours</a>
          
              </li>
              
              <li class="nav-item mb-3">
                  <a href="{{ route('task.a_venir') }}" class="@if ($route == 'task.a_venir')
              text-dark
              @endif">Taches non démarrées</a>
              </li>
              <li class="nav-item mb-3">
                  <a href="{{ route('task.retard') }}" class="@if ($route == 'task.retard')
              text-dark
              @endif">Taches terminées avec retard</a>
              </li>
              <li class="nav-item mb-3">
                  <a href="{{ route('group.im.member') }}" class="@if ($route == 'task.retard')
              text-dark
              @endif">Les groupes dont je suis membre</a>
              </li>
            </ul>
        </div>
     </div>
   {{-- Fin colonne des menus --}}

    {{-- Stats --}}

      <div class="col-md-9">
          <div class=" text-center">
              <h3 class=" text-info mb-4">Statistiques des taches</h3>
              <div class="m-3">
                @include('task.statistiques')
              </div>
          </div>
      </div>
    {{-- Fin Stats --}}

    {{-- Les tache à echances proches sur la page statistique --}}
    <div class=" text-center mb-3">
      <h3 class="text-info">Ces taches sont à écheance plus proches</h3>
    </div>
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
    {{-- Fin des taches les plus proches --}}
  </div>
@endsection