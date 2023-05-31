<x-mail::message>
# Une nouvelle tache vous a été assignée

Consulter votre compte. <br><br>

<p>{{ $group->user->name }} vous a confié une tache dans le groupe {{ $group->name }}</p> <br><br>
<h5>{{ $group->user->name }}</h5> <br><br>

<div>
    <a href="{{ route('task.edit', ['task' => $task->id])}}">Cliquer ici pour voir plus sur la tache</a>
</div>


<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
