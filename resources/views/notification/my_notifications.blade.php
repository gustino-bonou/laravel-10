@extends('base')

@section('title')
    Vos notifications
@endsection

@section('content')
    <div class="text-center mt-4">
        <h3 class="mb-20 mt-lg-n1 text-info">@yield('title')</h3>
    </div>

    {{-- <div class="row">
        <div class="m-5 col">

            <div class="  bg-gray-100 m-5">
                <h3>Ces devraient demarrer aujourd'hui cet jour </h3>
    
                @forelse ($taskBeginned as $task)
                    <h6>Tache: {{ $task->name }}</h6>
                    <p>Description {{ $task->description }}</p>
    
                    <a href="{{ route('task.marque.begin', ['task' => $task->id]) }}">Marquer cette tache comme demarrée</a><br>
                    <a href="{{ route('task.edit', ['task' => $task->id]) }}">Voir plus</a>
                @empty
                    
                @endforelse
            </div>
            
        </div>
        <div class="m-5 col">
    
            <div class="  bg-gray-100 m-5">
                <h3>Ces devraient terminer aujourd'hui</h3>
    
                @forelse ($taskFinished as $task)
                    <h6>Tache: {{ $task->name }}</h6>
                    <p>Description {{ $task->description }}</p>
    
                    <a href="{{ route('task.marque.finish', ['task' => $task->id]) }}">Marquer cette tache comme terminée</a><br>
                    <a href="{{ route('task.edit', ['task' => $task->id]) }}">Voir plus</a>
                @empty
                    
                @endforelse
            </div>
            
        </div>
    </div>
    <div class="row">
        <div class="mb-5 col">
    
            <div class="  bg-gray-100 m-5">
                <h3>Invitation de rejoindre groupe</h3>
    
                @forelse ($invitationsGroup as $group)
                    <h6>Groupe: {{ $group->name }}</h6>
                    <p>Description {{ $group->description }}</p>
                    <p>Auteur {{ $group->user->name }}</p>
    
                    <a href="{{ route('group.attach.user', ['group' => $group->id, 'user' => Auth::id() ]) }}">Rejoindre le groupe</a><br>
                @empty
                    
                @endforelse
            </div>
            
        </div>
        <div class="mb-5 col">
    
            <div class="  bg-gray-100 m-5">
                <h3>Les nouvelles tache pour vous</h3>
    
                @forelse ($assignTasks as $assignTask)
                    <h6>Groupe: {{ $assignTask['group']->name }}</h6>
                    <p>Description {{ $assignTask['group']->description }}</p>
                    <p>Auteur {{ $assignTask['group']->user->name }}</p>
    
                    <a href="{{ route('task.edit', ['task' => $assignTask['task']->id]) }}">Voir la tache</a><br>
                @empty
                    
                @endforelse
            </div>
            
        </div>
        <div class="mb-5 col">
    
            <div class="  bg-gray-100 m-5">
                <h3>Les taches écheance proche</h3>
    
                @forelse ($taskEcheances as $task)
                    <h6>Tache: {{ $task->name }}</h6>
                    <p>Description {{ $task->description }}</p>
    
                    <a href="{{ route('task.edit', ['task' => $task->id]) }}">Voir plus</a><br>
                @empty
                    
                @endforelse
            </div>
            
        </div>
    </div>
 --}}

    @forelse ($tableNotifs as $tableNotif)
        @if ($tableNotif['type'] === 'begin')
            <div class="notification">
                <h4>Tache: {{ $tableNotif['object']}}</h4>
                <h6>Tache: {{ $tableNotif['task']->name }}</h6>
                <p>Description {{ $tableNotif['task']->description }}</p>

                <a href="{{ route('task.marque.begin', ['task' => $tableNotif['task']->id]) }}">Marquer cette tache comme demarrée</a><br>
                <a href="{{ route('task.edit', ['task' => $tableNotif['task']->id]) }}">Voir plus</a>
            </div>
        @endif

        @if ($tableNotif['type'] === 'finish')
            <div class="notification">
                <h4>Tache: {{ $tableNotif['object']}}</h4>
                <h6>Tache: {{ $tableNotif['task']->name }}</h6>
                <p>Description {{ $tableNotif['task']->description }}</p>

                <a href="{{ route('task.marque.begin', ['task' => $tableNotif['task']->id]) }}">Marquer cette tache comme demarrée</a><br>
                <a href="{{ route('task.edit', ['task' => $tableNotif['task']->id]) }}">Voir plus</a>
            </div>
        @endif

        @if ($tableNotif['type'] === 'echeance')
            <div class="notification">
                <h4>{{ $tableNotif['object']}}</h6>
                <p>Tache: {{ $tableNotif['task']->name  }}</p>
                <p>Description {{ $tableNotif['task']->description  }}</p>

                <a href="{{ route('task.edit', ['task' => $tableNotif['task']->id ]) }}">Voir plus</a><br>
            </div>
        @endif

        @if ($tableNotif['type'] === 'tacheAssignee')
            <div class="notification">
                <h4> {{ $tableNotif['object'] }}</h4>
                <h6>Groupe: <span> {{ $tableNotif['group']->name }}</span></h6>
                <h6>Tache: <span>{{ $tableNotif['task']->name}}</span></p>

                <a href="{{ route('task.edit', ['task' => $tableNotif['task']->id]) }}">Voir la tache</a><br>
            </div>
        @endif

        @if ($tableNotif['type'] === 'invitation')
            <div class="notification">
                <h4> {{ $tableNotif['object'] }}</h4>
                <h6>Groupe: {{ $tableNotif['group']->name }}</h6>
                <p>Description {{ $tableNotif['group']->description }}</p>
                <p>Auteur {{ $tableNotif['group']->user->name }}</p>

                <a href="{{ route('group.attach.user', ['group' => $tableNotif['group']->id, 'user' => Auth::id() ]) }}">Rejoindre le groupe</a><br>
            </div>
        @endif

    @empty
        
    @endforelse
@endsection