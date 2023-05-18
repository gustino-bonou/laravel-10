<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <style> 

   

    </style>
</head>
<?php 

?>
<body>
<div class="p-3 mb-2 bg-primary text-white">
<ul class="nav justify-content-start ">
 <li class="nav-item">
    <a class="nav-link   text-white " href="{{ route('task.index') }}">Accueil</a>
  </li>
  <li class="nav-item" >
    <a class="nav-link  text-white " href="/" >Accueil test</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-white  " href="{{ route('task.statistiques') }}" tabindex="-1" aria-disabled="false">Menu</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-white  " href="{{ route('group.index') }}" tabindex="-1" aria-disabled="false">Groups</a>
  </li>




  @auth

  <a class="nav-link   text-white " href="{{ route('blog.index') }}">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
  
  <form action="{{ route('auth.logout') }} " method="post">

    @method("delete")
    @csrf
    
    <button class="nav-link btn btn-primary">Se déconnecter </button>
  </form>
  @endauth

  @guest
    <a class="nav-link text-white" href="{{ route('auth.login') }}">Se connecter</a>
  @endguest

</ul>
</div>



    <div class="container">
      

      @include('shared.flash')

      
        @yield('content')
    </div>

</body>
</html>