@extends('base')

@section('title', 'Se connecter')


@section('content')

<div class="card">
<div class="card-body">
<form action="{{ route('auth.login') }}" method="post" class="vstack gap-3">

@csrf
<div class="form-group">

    <label for="email"> Email </label>

    <input type="email" name="email" id= "email" class="form-control" value="{{ old('email') }}">

    @error('email')
        {{ $message }} 
    @enderror
        
</div>

<div class="form-group">

    <label for="email"> Mot de passe </label>

    <input type="password" name="password" id= "password" class="form-control" value="">

    @error('password')
        {{ $message }} 
    @enderror
        
</div>
<button class="btn btn-primary"> Se connecter </button>
</form>
</div>
</div>

@endsection