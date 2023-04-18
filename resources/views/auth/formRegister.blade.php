@extends('base')

@section('title', "S'inscrire")


@section('content')

    

<form action="" method="post">

@csrf


<div class="form-group">

<label for="name"> Votre nom</label>

<input type="text" name="name" id= "name" class="form-control" value="{{ old('name') }}">

@error('name')
    {{ $message }} 
@enderror
    
</div>

<div class = form-group> 

<label for="category">Votre email</label>

    <input type="email" id= "email" class="form-control"  name="email" value="{{ old('email') }}">
    
    @error('email')
    
    {{ $message }}
    
    @enderror

</div>


<div class="form-group">


    <label for="password">Mot de passe</label>
    <input type="password" name="password" id= "password" class="form-control">    

    @error('password')
        {{ $message }} 
    @enderror
        
</div>
<div class="form-group">


    <label for="password_confirmation">Confirmer Mot de passe</label>
    <input type="password" name="password_confirmation" id= "password_confirmation" class="form-control">    

    @error('password_confirmation')
        {{ $message }} 
    @enderror
        
</div>
<button class="btn btn-primary">S'inscrire</button>

</form>

@endsection