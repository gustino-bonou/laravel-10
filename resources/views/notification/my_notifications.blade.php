@extends('base')

@section('title')
    Vos notifications
@endsection

@section('content')
    <div class="text-center mt-4">
        <h3 class="mb-20 mt-lg-n1 text-info">@yield('title')</h3>
    </div>

    <div class="">
        @forelse ($notifications as $notification)

        <div class="m-3">

            <h5>{{$notification["object"]}}</h5>

            @if ($notification["group"] !== null){{-- Donc il y un group, soit pour invitation soit pour task assignée --}}
             <h6>Groupe: {{$notification["group"]->name}}</h6>
             <p>Description: {{$notification["group"]->description}}</p>
             <p>Auteur: {{$notification["group"]->user->name}}</p>

             @if ($notification["type"] === 1){{-- donc nouvelle tache dans un groupe, alors i exite bien un groupe et une tache --}}
             <a href="{{ route('task.edit', ['task' => $notification["task"]->id])}}">Cliquer ici pour voir plus</a>
             @endif
             @if ($notification["type"] === 2){{-- donc invitation de rejoindre un groupe --}}
             <a href="{{ route('group.attach.user', ['group' => $notification["group"]->id, 'user' => Auth::user()])}}">Accepter l'invitation</a> <br><br>
             @endif

            @else

            <a href="{{ route('task.edit', ['task'=>$notification["task"]->id])}}">Voir plus sur la tache</a><br><br>

            <a href="{{ route('task.notifiable', ['tache' => $notification["task"]->id])}}">Ne plus recevoir de notifications pour cette tache</a><br><br>

            @endif
        </div>
        
            
        @empty
            
        @endforelse
    </div>
@endsection