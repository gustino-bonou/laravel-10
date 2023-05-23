@extends('base')

@section('title')
    Mes groupes
@endsection

@section('content')

<?php
$route = request()->route()->getName();
?>

    

<div class=" text-center my-3 d-flex gap-4 w-100  align-content-center align-items-center  justify-content-between">
    
  <a href="{{ route('group.index') }}" class=" @if ($route === 'group.index') link-clicked-group
      
  @endif" >Mes groupes créés</a>
  <a href="{{ route('group.im.member') }}" class="@if ($route == 'group.im.member') link-clicked-group
      
  @endif">Les groupe que j'ai rejoints</a>
  <a href="{{ route('group.create') }}">Créer un groupe</a>

</div>
  

<div>
    <div class="row">
      @forelse ($groups as $group)
      <div class="col-sm-4">
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">{{ $group->name }}</h5>
            <p class="card-text">{{ $group->description }}</p>
            
            @can('workspace', $group)
              <a href="{{ route('group.workspace', $group)}}" class="btn btn-primary">Action</a>
            @endcan
            
          </div>
        </div>
      </div>
      @empty
        
      <div class=" text-center">
        <h5>Vous n'avez créé aucun groupe</h5>
    </div>
  
      @endforelse
    </div>

</div>
</div>


@endsection