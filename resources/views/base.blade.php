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

<div class="">
<ul class="nav p-3 mb-2 bg-primary d-flex bd-highlight mb-3">
 <li class="nav-item  p-2 bd-highlight">
    <a class="nav-link   text-white " href="{{ route('blog.index') }}">Blog</a>
  </li>
  <li class="nav-item p-2 bd-highlight" >
    <a class="nav-link  text-white " href="/" >Accueil test</a>
  </li>
  <li class="nav-item ml-auto p-2 bd-highlight">
    @auth

    <div class="justify-content-center">

    <a class="nav-link   text-white " href="{{ route('blog.index') }}">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
    
    <form action="{{ route('auth.logout') }} " method="post">
  
      @method("delete")
      @csrf
      
      <button class="nav-link btn btn-primary nav-item">Se déconnecter </button>
    </form>
  </div>
    @endauth
  
    @guest
      <a class="nav-link text-white" href="{{ route('auth.login') }}">Se connecter</a>
    @endguest
  </li>






</ul>
</div>



    <div class="container">
      

      @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
      @endif

      
        @yield('content')
    </div>

</body>
</html>