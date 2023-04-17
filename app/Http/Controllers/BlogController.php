<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\FormPostRequest;
use App\Http\Requests\CreatePostRequest;

class BlogController extends Controller
{
    public function index(): View {

        
        /* Maintenant on aimerait etre capable d'associer une categorie à une article et aussi pouvoir les recuprerr
        juste pour un exemple, on recupere les post 2, on lui associe la catégorie de l'id = 1 comme ceci
        
        */
        /* $post = Post::find(2);

        


        $post->category_id = 1;

        dd($post); */

        /* Cela marche, mais Eloquent permet la meme operation facilement */
       
        //$post = Post::find(2);


        //cette ligne cherche automatique la categorie liée à l'article 
      
        //$categorie = $post->category->name;

       /* on imagine un moment cette requet
       $posts = Post::all();

       foreach($posts as $post){
        $categorie = $post->category->name;
       }
       */

       
       /* Donc ca fait trop de requete demandées si on a plusieurs articles
       Ainsi vient le probleme n+1. Pour éviter ca, on fait EagerLoading, precharger les relations,
       On lui dit de chager les information avec les categorie comme ceci
       $posts = Post::with('category')->get();
       La methode with est à revoir
       Autre point, cette relation peut etre inversée
       Au niveau de category, on peut ecrire une fonction posts pour dire q'une categorie à plusieurs articles
       ;
       */ 

       //$category = Category::find(1);

       //dd($category->posts);

       //dd($category->posts()->where('id', '>', '10')->get());

       /* Si on veut associer ou dissocier une categorie à un article */

       /* $category = Category::find(1);
       $post = Post::find(1);
       $post->category()->associate($category);
       $post->save(); */



       //Association relation many to many

       //recuperation de l'article 2

       //$post = Post::find(3);

       //Partir des relations pour créer des tags. De cette manière, on créer des 
       //tags 1 et 2, on fait en meme temps la liason dans la table post_tag, genre post2 associé à tag1 et post2 associé à tag2

       /* $post->tags()->createMany([[
        'name' => 'Tag 1'
       ],
       [
        'name' => 'Tag 2'
       ]]);  */

       //liste des tags de post 2 ($post = Post::find(2);)

       //dd($post->tags);

       //requetes sur les tags récuperés
       //dd($post->tags()->where('name', 'Tag 2')->get());


       //Detacher un tag particulier(pour supprimer le tag2 de l'article2 par exemple $post = Post::find(2);)

       //dd($post->tags()->detach(7));
       
       //Attacher un tag particulier(pour supprimer le tag2 de l'article2 par exemple $post = Post::find(2);)
        //dd($post->tags()->attach(7));

        //supprimer la relation d'un article et d'un tag de la table post_tag

        //$post->tags()->sync(6);

        //tout supprimer

        //$post->tags()->sync([6,7]);

        //récuperer des posts qui ont au moins un tag

        //Post::has('tags', '>=', 1)->get();

        /* Recuperartion des tags et category associés à un nos post */

       
        return view('blog.index', [
            'categories' => Category::paginate(3),
            'posts' => Post::with('tags', 'category')->paginate(10)
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
        $categories = Category::select('id', 'name')->get();
        $tags = Tag::select('id', 'name')->get();
        return view('blog.create', [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags
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

        $post->tags()->sync($request->validated('tags'));


        return redirect()->route('blog.show', ['slug' => $post->slug, 'post' => $post->id])->with('success', "L'article a été bien sauvegardé");
        
    } 

    public function edit(Post $post) {
        //ici on recupere toutes les categories qu'on envoie à la page d'edition
        //on devait faire Category::all() pour tout recuperer, mais nous on veut juste id et name
        return view('blog.edit', [
            'post' => $post,
            'categories' => Category::select('id', 'name')->get(),
            'tags' => Tag::select('id', 'name')->get()
        ]);
    }

    public function update(Post $post, FormPostRequest $request) {        
        
    
        $post->update($request -> validated());

        //Avec la ligne suivante, on recupere la list des tags liés au post
        //on fait sunc pour pouvoir modifier à présent cette liste et y mettre les valeurs qui
        //viennent du champs tags du formulaire 

        

        $post->tags()->sync($request->validated('tags'));


        return redirect()->route('blog.show', ['slug' => $post->slug, 'post' => $post->id])->with('success', "L'article a été bien modifié");
    }

    public function articleCategorie($categorie){

        return view('blog.posts_categorie', [
            'categories' => Category::paginate(3),
            'category' => Category::find($categorie),
            'posts' => Post::with('tags', 'category')->where('category_id', $categorie)->paginate(3),
        ]);
    }

}
