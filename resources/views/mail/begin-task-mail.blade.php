<x-mail::message>
# Cette tache demarre aujourd'hui

<h6>Tache: {{ $task->name }}</h6><br>
<p>Description {{ $task->description }}</p><br>
    
<a href="{{ route('task.marque.begin', ['task' => $task->id]) }}">Marquer cette tache comme demarrée</a><br>
<a href="{{ route('task.edit', ['task' => $task->id]) }}">Voir plus</a><br>

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
