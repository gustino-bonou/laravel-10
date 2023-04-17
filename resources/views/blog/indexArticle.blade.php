@foreach($posts as $post)
<article>
    <h2>
    {{ $post->title }}
    </h2>
    <p class="small">
        <!-- Affichage des catégories au cas où il y en a -->
        @if($post->category)
        Catégorie: <strong>{{ $post->category->name }}</strong> </p>
        @endif
        <!-- Vérification si le post possède des tags; les tags dans ce cas sont sous forme de collection, donc on utilise isempty -->
        @if(!$post->tags->isEmpty())
            Tag:
            @foreach($post->tags as $tag)
                <span class="badge bg-secondary">{{ $tag->name }}, </span>
            @endforeach
        @endif


    <p>
        {{ $post->content }}
    </p>
    <p>

        
        <a href="{{ route('blog.show', ['slug'=>$post->slug, 'post'=>$post->id])}}" class="btn btn-primary">Lire la suite</a>
    </p>
       
</article>
@endforeach

{{ $posts->links() }}