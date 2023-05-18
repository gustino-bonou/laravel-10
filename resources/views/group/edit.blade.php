
@extends('base')

@section('title', 'Créer un group')

@section('content')

    <div class="text-center mt-4">
        <h3 class="mb-20 mt-lg-n1 text-info">@yield('title')</h3>
    </div>

    <form class="vstack gap-3" action="{{ route('group.store') }}" method="post" enctype="multipart/form-data">

        @csrf
        @method('post')

        @include('shared.input', [
            'name' => 'name',
            'holder' => 'Nom du group',
        ])
    
        @include('shared.input', [
                'name' => 'description',
                'holder' =>'Décrivez le groupe',
                'type' => 'textarea',
        ])

        
        <div>
            <div class="form-group form-check-inline">
                <label for="" class="mr-5">Recevoir de notification pour ce groupe</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="notifiable" id="oui" value={{1}} checked>
                    <label class="form-check-label" for="oui">Oui</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="notifiable" id="non" value={{0}} >
                    <label class="form-check-label" for="non">Non</label>
                </div>
            </div>
        </div>


        <button class="btn btn-primary mb-5">

            Créer
            
        </button>       
    </form>

    <script>
        // Initialisation du datepicker Bootstrap
        
    </script>
@endsection


