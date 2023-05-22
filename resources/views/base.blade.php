@extends('base_commune')

@section('nav')

{{-- <div class="p-3 mb-2 bg-primary text-white row"> --}}
{{-- 
<div class="col">
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
</div> --}}


{{-- </div> --}}



    <div class=" container-fluid m-3">
      

      @include('shared.flash')

      
        @yield('content')
    </div>

    
@endsection