<div class="row mb-5">
    <div class="col-md-3">
      <!-- Sidebar -->
      <div class="sidebar ">
        
        <ul class="nav flex-column">
          <li class="nav-item mb-3">
              <a href="{{ route('task.create', ['group' => $group->id]) }}">Créer une tache</a>
          </li>

          <li class="nav-item mb-3">
              <a href="{{ route('group.tasks.index', $group->id) }}" >Toutes les taches du groupe</a>
          </li>
          
          <li class="nav-item mb-3">
            <a href="{{ route('group.tasks.terminees', $group->id) }}">Taches  Terminées</a>
      
          </li>
          <li class="nav-item mb-3">
            <a href="{{ route('group.tasks.en.cours', $group->id) }}" >Taches  en cours</a>
      
          </li>
          
          <li class="nav-item mb-3">
              <a href="{{ route('group.tasks.non.demarrees', $group->id) }}">Taches non démarrées</a>
          </li>
          <li class="nav-item mb-3">
              <a href="{{ route('group.tasks.terminees.retard', $group->id) }}" >Taches terminées avec retard</a>
          </li>
        </ul>
      </div>
      
    </div>
    <div class="col-md-9">
      <div class="sidebar text-end">
        <div>
          <a href="">
            
          </a> 
        </div>
      </div>
      

    </div>
  </div>