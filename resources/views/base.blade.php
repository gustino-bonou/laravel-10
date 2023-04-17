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
<ul class="nav justify-content-end">
  <li class="nav-item">
    <a class="nav-link   text-white " href="{{ route('blog.index') }}">Blog</a>
  </li>
  <li class="nav-item" >
    <a class="nav-link  text-white " href="/" >Accueil test</a>
  </li>
  <li class="nav-item">
    <a class="nav-link disabled  " href="#" tabindex="-1" aria-disabled="false">Link</a>
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