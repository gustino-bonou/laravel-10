<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>



    
   @vite(['resources/css/app.css'])

{{--     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 --}}    
    <style> 

   

    </style>
</head>
<?php 
if (Auth::user()) {
  $nbrNotif = Auth::user()->unreadnotifications()->count();

  $rnbrNotif = Auth::user()->notifications()->count();
}

$route = request()->route()->getName();
?>
<body>
<div class="p-3  bg-primary text-white row div-commune">

<div class="col-9">
  <ul class="nav justify-content-start div-commune-content">
    <li class="nav-item">
       <a class="nav-link   text-white base-comune-link-hover
        @if ($route == 'home' || $route == 'task.index' || $route == 'task.terminees' || $route == 'task.en_cours'
        || $route == 'task.a_venir' || $route == 'task.retard')
       link-clicked @endif" href="{{ route('home') }} ">Espace Personnel</a>
    </li>
     <li class="nav-item" >
       <a class="nav-link  text-white base-comune-group-link-hover
       @if (str_contains($route, 'group')) link-clicked-group
        @endif" href="{{route('group.index')}}" >Espace groupe</a>
     </li>
   
     @auth
   
     <a class="nav-link   text-white  base-comune-link-hover" href="{{ route('blog.index') }}">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>

     @endauth
   
     @guest
       <a class="nav-link text-white base-comune-link-hover" href="{{ route('auth.login') }}">Se connecter</a>
     @endguest
   </ul>
</div>
<div class="col text-end">
  @auth
  <ul class="nav justify-content-end gap-0">
    <li class="nav-item">
      {{-- <form action="{{ route('auth.logout') }} " method="post">
   
        @method("delete")
        @csrf
        
        <button class="nav-link btn text-white base-comune-link-hover">Se déconnecter </button>
      </form> --}}
     </li>
    <li class="nav-item  ">
      <a href="{{route('task.group.mynotificaions')}}" class=" text-white nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-bell-slash-fill " viewBox="0 0 16 16">
          <path d="M5.164 14H15c-1.5-1-2-5.902-2-7 0-.264-.02-.523-.06-.776L5.164 14zm6.288-10.617A4.988 4.988 0 0 0 8.995 2.1a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 7c0 .898-.335 4.342-1.278 6.113l9.73-9.73zM10 15a2 2 0 1 1-4 0h4zm-9.375.625a.53.53 0 0 0 .75.75l14.75-14.75a.53.53 0 0 0-.75-.75L.625 15.625z"/>
        </svg>
      </a>
     </li>
    @auth
    <li class="nav-item @if ($nbrNotif > 0) text-danger @endif font-weight-light fs-4">
      {{$rnbrNotif}}
    </li>
    @endauth

     
  </ul>
  @endauth
</div>

</div>
@auth
<form action="{{ route('auth.logout') }}" method="post" class="text-end">
  @csrf
  @method('delete')
  <button class="btn  btn-secondary">Se deconnecter</button>
</form>
@endauth


<div class="m-5">
  @yield('nav')
</div>
      
   

</body>
</html>