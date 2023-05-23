
<!DOCTYPE html>
<html>
<head>
<style>


h1 {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  color: rgb(32, 124, 167);
}
</style>
</head>
<body>

    <div class=" align-items-center align-content-between container bg-gray-300 m-5">
        <h1 class="m-3">Tache numéro {{ $tache->id }}</h1>
      
      <h4 class="m-3">Tache: {{ $tache->name }}</h3>

      <h4 class="m-3">Description:  {{ $tache->description }}</p>
      
      <div>
        <p>
            <h5 class="m-2">Date debut prevue: {{ $tache->begin_at }}</h5>
            <h5 class="m-2">Date debut effective: @if ( $tache->beginned_at !== null)
                {{ $tache->beginned_at }}
        
                @else Non demarrée
            @endif</h5>
            <h5 class="m-2">Date fin prevue: {{ $tache->finish_at }}</h5>
            <h5 class="m-2">Date fin effective: @if ( $tache->finished_at !== null)
                {{ $tache->finished_at }}
        
                @else Non terminée
            @endif</h5>
        </p>
      </div>
      
    </div>


</body>
</html>





