
@extends('base')

@section('title', 'S\'inscrire')

@section('content')

    <div class="text-center mt-4">
        <h3 class="mb-20 mt-lg-n1 text-info">@yield('title')</h3>
    </div>

    <form class="vstack gap-3" action="{{ route('auth.doRegister') }}" method="post" enctype="multipart/form-data">

        @csrf
        @method('post')

        @include('shared.input', [
            'name' => 'name',
            'holder' => 'Votre nom',
        ])
    
        @include('shared.input', [
            'name' => 'email',
            'holder' => 'Votre adresse email',
        ])
    
        @include('shared.input', [
                'name' => 'password',
                'label' => 'Mot de passe',
                'type' => 'password',
        ])
        @include('shared.input', [
                'name' => 'password_confirmation',
                'label' => 'Confirmer votre mot de passe',
                'type' => 'password',
        ])

<div class=" d-flex align-content-between m-4  align-items-center  justify-content-between">
    <a href="{{ route('auth.login') }}" class=" btn btn-secondary mr-4  btn-sm">ou se connecter</a>
    <button class="btn btn-primary btn-sm"> S'inscrire </button>

</div>

             
    </form>

@endsection


