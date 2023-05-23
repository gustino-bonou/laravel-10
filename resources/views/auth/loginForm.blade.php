@extends('base')

@section('title', 'Se connecter')


@section('content')

<div class="card">
<div class="card-body">
<form action="{{ route('auth.login') }}" method="post" class="vstack gap-3">

@csrf
<div class="form-group m-4">

    <label for="email"> Email </label>

    <input type="email" name="email" id= "email" class="form-control" value="{{ old('email') }}">

    @error('email')
        {{ $message }} 
    @enderror
        
</div>

<div class="form-group m-4">

    <label for="email"> Mot de passe </label>

    <input type="password" name="password" id= "password" class="form-control" value="">

    @error('password')
        {{ $message }} 
    @enderror
        
</div>
<div class=" d-flex align-content-between m-4  align-items-center  justify-content-between">
    <a href="{{ route('auth.register') }}" class=" btn btn-secondary mr-4  btn-sm">ou s'inscrire</a>
    <button class="btn btn-primary  btn-sm"> Se connecter </button>

</div>
</form>
</div>
</div>

@endsection