@extends('base')

@section('title')
    Assigner de roles aux membres du groupe
@endsection

@section('content')
    <div class="text-center mt-4">
        <h3 class="mb-20 mt-lg-n1 text-info">@yield('title')</h3>
    </div>

    <div class="container">
        <form action="{{ route('group.assign.rol', ['task' => $task->id])}}" class=" form-group" method="post">

            @csrf
            @method('post')

            @forelse ($users as $user)
                <div class="my-5">
                    <div class=" form-check">
                        <input class="form-check-input" type="checkbox" name="users[]" id="lower" value="{{$user->id}}" >
                        <label class="form-check-label" for="lower">{{$user->name}}</label>
                    </div>
                </div>
            @empty
                
            @endforelse
            
    
            <button class="btn btn-primary mb-5 ">
    
                Assigner
    
            </button>
        </form>
    </div>
@endsection