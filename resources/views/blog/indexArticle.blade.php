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

        @if($post->image)
            <div>
                <img style="margin-top: 5%; width: 100%; height: 200px; object-fit: cover" 
                src="{{ $post->imageUrl()}}" alt="{{ $post->title }}"
                class="rounded float-right float-xl-left " >
            </div>
        @endif


    </p>
    <p>
        {{ strlen($post->content)<200 ? $post->content : substr($post->content, 200) }}
    </p>
    <p>

        
        <a href="{{ route('blog.show', ['slug'=>$post->slug, 'post'=>$post->id])}}" class="btn btn-primary">Lire la suite</a>
    </p>
       
</article>
@endforeach

{{ $posts->links() }}