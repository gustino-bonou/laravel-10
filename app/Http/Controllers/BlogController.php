<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\FormPostRequest;
use App\Http\Requests\CreatePostRequest;

class BlogController extends Controller
{
    public function index(): View {
        return view('blog.index', [
            'posts' => Post::paginate(2)
        ]);
    }

    public function show(string $slug, $post): RedirectResponse | View{
        $post = Post::find($post);
        

        return view('blog.show', [
            'post' => $post
        ]);
    }

    public function create(){

        /* puisque le formulaire est commun à create et modifie, et que modifie prend
        necessairement un post, on crée aussi un post qu'on envoie au fichier create
        il fait pas grande chose avec*/

        $post = new Post();
        $post->title = "Le titre";
        $post->content = "Le contenu";
        return view('blog.create', [
            'post' => $post
        ]);
        
    }


    /* cette fonction prend un objet de type FormPostRequest qui étend de FormRequest 
    permettant de valider les données envoyées depuis le formulaire
    FormPostRequest contient une methode validated qui contien sous forme de tableau
    associatif les données validée
    */
    public function store(FormPostRequest $request){
        
        $data = $request->validated(); 
        
        $post = Post::create($data);


        return redirect()->route('blog.show', ['slug' => $post->slug, 'post' => $post->id])->with('success', "L'article a été bien sauvegardé");
        
    } 

    public function edit(Post $post) {
        return view('blog.edit', [
            'post' => $post
        ]);
    }

    public function update(Post $post, FormPostRequest $createPostRequest) {
        $post->update($createPostRequest -> validated());

        return redirect()->route('blog.show', ['slug' => $post->slug, 'post' => $post->id])->with('success', "L'article a été bien modifié");
    }
}
