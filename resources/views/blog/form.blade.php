

<form action="" method="post" enctype="multipart/form-data">

    @csrf


    @method($post->id ? "PATCH" : "POST")
   <div class="form-group">

    <input type="text" name="title" id= "title" class="form-control" value="{{ old('title', $post->title) }}">

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


    <div class="form-group">
    

        <label for="category">Catégorie</label>
        <select type="text" name="category_id" id= "category" class="form-control">

        <option value="">Selectionner la catégorie</option>
        @foreach($categories as $category)
            <option @selected(old('category_id', $post->category_id) == $category->id)  value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach

        </select>
        

        @error('category_id')
            {{ $message }} 
        @enderror
            
   </div>
   <?php 
   $tagsIds = $post->tags()->pluck('id')
   ?>
    <div class="form-group">
    

        <label for="tag">Tags</label>
        <select type="text" name="tags[]" id= "tag" class="form-control" multiple>

        @foreach($tags as $tag)
            <option @selected($tagsIds->contains($tag->id)) value="{{ $tag->id }}">{{ $tag->name }}</option>
        @endforeach

        </select>
        

        @error('tags')
            {{ $message }} 
        @enderror
            
   </div>

   <div class="form-group">

    <input type="file" name="image" id= "image" class="form-control">

    @error('image')
        {{ $message }} 
    @enderror
        
   </div>

    <button class="btn btn-primary">
        @if($post -> id)
            Modifier
        @else
            Créer
        @endif

    </button>

</form>