@extends('base')

@section('title')
    Mes groupes
@endsection

@section('content')

<?php
$route = request()->route()->getName();
?>

<div class="text-center mt-4">
    <a href="{{ route('group.create') }}">Créer un groupe</a>
    <h3 class="my-5 mt-lg-n1 text-info">@yield('title')</h3>

    

<div>
  <div class="row ">
    @forelse ($groups as $group)
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 >  
                {{$group->name}} 
              </h5>
              <p class="card-text ">{{ Str::substr($group->description, 0, 25) }}</p>
              <div class="d-flex  align-items-center justify-content-md-start ">
                  <a href="" class=" card-link">Work Space</a>
                  
              </div>

            </div>
          </div>
        </div>
    @empty
        
    @endforelse

    <div class=" text-center">
        <h5>Aucun groupe</h5>
    </div>
    
  </div>
</div>
</div>
    
@endsection