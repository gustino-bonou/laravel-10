<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>


{{--     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 --}}    
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



    <div class=" container-fluid m-3">
      

      @include('shared.flash')

      
        @yield('content')
    </div>

</body>
</html>