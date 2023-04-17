@extends('base')
@section('title')

{{ $category->name }}

@endsection

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