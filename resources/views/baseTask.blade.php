<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <link href=”https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css” rel=”stylesheet”> 
    <script src=”https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js”></script> 
    <script src=”https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js”></script>

    {{-- datetimepickker --}}

    <script type=”text/javascript” src=”https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js”></script>
    <link href=”https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css” rel=”stylesheet”>
    <script src=”https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js”> </script>



    <style>
        @layer reset{
          button {
            all:unset;
          }
        }
      
      </style>  
</head>
<body>

    <?php
      $route = request()->route()->getName();
      ?>
    <nav class="navbar navbar-expand-lg  bg-info">
          <ul class="nav  justify-content-center">
        
            <li class="nav-item" >
              <a class="nav-link @if($route == 'taches.home') text-green-600   @else   text-white  @endif"  href="{{ route('taches.home', ['typeTache' => 'en_cours'
            ]) }}" >Accueil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(str_contains($route, 'create'))
              text-green-600
                @else
              text-white
              @endif"  href="{{ route('taches.create') }}">Nouvelle tache</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(str_contains($route, 'statistiques.'))
              text-green-600
                @else
              text-white
              @endif"  href="{{ route('dashboard') }}" tabindex="-1" aria-disabled="false">Dashboard</a>
            </li>
            <li class="nav-item">
              
            </li>
            
    
            {{-- @class(['nav-link text-white', 'action' => str_contains($route, 'option.')]) --}}
            

            <li class="nav-item ">
                @auth
              
                <a class="nav-link text-white"  href="{{ route('profile.edit')}}" tabindex="-1" aria-disabled="false">Profile</a>

                @endauth
                
                @guest
                    <a class="nav-link text-white" href="{{ route('login') }}">Se connecter</a>
                @endguest
            </li>

          </ul>

    </nav>
      
    </div>

        <div class="container nt-3">

          @include('shared.flash')

          {{-- <div class="d-flex justify-content-between align-items-center my-5">
            <a href="{{ route('taches.index') }}" class="@if ($route == 'taches.index')
                text-dark
            @endif">Toutes mes taches</a>
        
            <a href="{{ route('taches.en_cours') }}" class="@if ($route == 'taches.en_cours')
            text-dark
            @endif">Taches  en cours</a>
        
            <a href="{{ route('taches.terminees') }}" class="@if ($route == 'taches.terminees')
            text-dark
            @endif">Taches terminées</a>
        
            <a href="{{ route('taches.a_venir') }}" class="@if ($route == 'taches.a_venir')
            text-dark
            @endif">Taches à venir</a>

            <a href="{{ route('export.view') }}" class="">Exporter les données</a>
        
            
          </div> --}}

        @yield('content')

    </div>
    
    <script>
      //tomSelect est une librairie pour modifier l'apparence de la balise select
      new TomSelect('select[multiple]', {plugins: {remove_button: 'Supprimer'}})
    </script>

  </body>
</html>
