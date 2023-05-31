
@extends('base')

@section('title', $tache->id == null ? 'Créer une tache': 'Modifier la tacche numéro ' . $tache->id)

@section('content')

    <div class="m-3">
        <div class="text-center mt-4">
            <h3 class="mb-20 mt-lg-n1 text-info">@yield('title')</h3>
        </div>
    
        <div class="m-5">
            <form class="vstack gap-3" action="{{ route($tache->exists ? 'task.update' : 'task.store', ['task' => $tache]) }}" method="post" enctype="multipart/form-data">
    
                @csrf
                @method($tache->exists ? 'put' : 'post')
        
                @include('shared.input', [
                    'name' => 'name',
                    'holder' => 'Nom de la tache',
                    'value' => $tache->name
                ])
            
                @include('shared.input', [
                        'name' => 'description',
                        'holder' =>'Décrivez la tache',
                        'type' => 'textarea',
                        'value' => $tache->description
                ])
        
                @include('shared.input', [
                    'name' => 'begin_at',
                    'holder' =>'date debut',
                    'type' => 'datetime-local',
                    'label' => 'Date debut',
                    'value' => $tache->begin_at
                ])
        
                @include('shared.input', [
                        'name' => 'finish_at',
                        'holder' =>'date fin',
                        'type' => 'datetime-local',
                        'label' => 'Date fin',
                        'value' => $tache->finish_at,
                ])
    
                <input type="hidden" name="group_id" value="{{$group}}">
                
                <div>
                    <div class="form-group form-check-inline m-4">
                        <label for="" class="">Recevoir de notification pour cette tache</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="notifiable" id="oui" value={{1}} @checked($tache->notifiable === 1) @checked($tache->id === null)>
                            <label class="form-check-label" for="oui">Oui</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="notifiable" id="non" value={{0}} @checked($tache->notifiable === 0)>
                            <label class="form-check-label" for="non">Non</label>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="form-group form-check-inline m-4">
                        <label for="" class="">Niveau</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="level" id="immediate" value="high" @checked($tache->level == 'high')>
                            <label class="form-check-label" for="immediate">High</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="level" id="important" value="medium" @checked($tache->level == 'medium') @checked($tache->id == null)>
                            <label class="form-check-label" for="important">Medium</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="level" id="lower" value="low" @checked($tache->level == 'low')>
                            <label class="form-check-label" for="lower">Low</label>
                        </div>
                    </div>
                </div>
        
                <div>
                    @if ($tache->id !== null)
                        @if ($tache->beginned_at !== null)
                            @include('shared.input', [
                            'name' => 'beginned_at',
                            'holder' =>'date fin',
                            'type' => 'datetime-local',
                            'label' => 'Cette tache à demarré le:',
                            'value' => $tache->beginned_at,
                            ])
                        @else
                        <h4 class="m-4">Text non démarrée</h4>
                            @include('shared.input', [
                            'name' => 'beginned_at',
                            'type' => 'hidden',
                            'label' => ' ',
                            ])
                        @endif
        
                        @if ($tache->finished_at !== null)
                            @include('shared.input', [
                            'name' => 'finished_at',
                            'holder' =>'date fin',
                            'type' => 'datetime-local',
                            'label' => 'Cette tache est terminée le:',
                            'value' => $tache->finished_at,
                            ])
                        @else   
                            @include('shared.input', [
                            'name' => 'finished_at',
                            'type' => 'hidden',
                            'label' => ' ',
                            ])
                        @endif
                    @endif
                </div>
                <div class=" text-center" class="m-3 container">
                    @if ($tache->id == null )
                    <button class="btn btn-primary btn-lg">
                            Créer
                    </button>
                    @else

                    @can('updateGroupTask', $tache)

                        <button class="btn btn-primary btn-lg">
                            Modifier
                        </button>

                    @endcan
                    @endif
                    
                </div>
                                       
            </form>

        </div>

        <div class=" m-5">
            @include('group.groupsTaskEdit')
        </div>

        @if ($tache->id !== null)
        <div>
            <ul>
                <li>
                    <a href="{{route('tasks.export', ['task' => $tache->id, 'type' => 'pdf'])}}">Exporter en pdf</a>
                </li>
                <li>
                    <a href="{{route('tasks.export', ['task' => $tache->id, 'type' => 'xlsx'])}}">Exporter en xlsx</a>
                </li>
                <li>
                    <a href="{{route('tasks.export', ['task' => $tache->id, 'type' => 'csv'])}}">Exporter en csv</a>
                </li>
            </ul>
            
        </div>
            
        @endif
    </div>
@endsection


