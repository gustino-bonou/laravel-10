<!-- C'est pratiquement le meme formulaire on utilise pour la création et la modification
d'un post, donc on prefere ecrire le formulaire dans un fichier à part
qui sera appelé par @include('chemin') quand on voudra l'utiliser -->

<form action="" method="post">
    <!-- Appel au middlware csrf pour le traitement avant que les données ne parviennent à notre controller
    afin que laravel soit sur que les donnes proviennt du navigateur, pour la sécurité.
    Cette directive crée un champ caché qui contient un token unique, ce token permet la vérification des données 
-->
    @csrf

    <!-- Normalement pour la modification des données, c'est la methode patch qui est la plus idéale
    meme si on peut utiliser post. Mais les navigateurs ou formulaires? ne prennent pas compte le patch
    laravel possede une directive @method afin d'indiquer la methode qu'on voudra utiliser dans le formualire
-->
    @method($post->id ? "PATCH" : "POST")
   <div class="form-group">

    <input type="text" name="title" id= "title" class="form-control" value="{{ old('title', $post->title) }}">
    
    <!-- gestion des erreurs avec la directive @error, conforment aux regles définies, 
    cette directive permet de signaler le champ non valid, on a plus rien affaire
    pour notifier cela à l'utilisateur, c'est automatique mais on peut modifier la gestion des erreurs(la présentation)
-->
    @error('title')
        {{ $message }} 
    @enderror
        
   </div>

    <div class = form-group>

        <textarea id= "content" class="form-control"  name="content">{{ old('content', $post->content) }}</textarea>
        
        @error('content')
        
        {{ $message }}
        
        @enderror

    </div>

    <button class="btn btn-primary">
        <!-- ici, on vérifie si le post envoyé contient un id, on affiche le message créer our modifier -->
        @if($post -> id)
            Modifier
        @else
            Créer
        @endif
    </button>

</form>