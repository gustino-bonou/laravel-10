@extends('base')
@section('title', 'Acueil Blog')
@section('content')

<div>
<ul class="nav justify-content-center">
    @foreach($categories as $category)

    <li class="nav-item">
    <a class="nav-link   text-success " href="{{ route('blog.articleCategorie', $category->id) }}">{{ $category->name}}</a>
    </li>

    @endforeach

</ul>
</div>

@include('blog.indexArticle')


@endsection