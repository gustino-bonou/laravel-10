<x-mail::message>
# Le deadline de cette tache est aujourd'hui

<h6>Tache: {{ $task->name }}</h6>
<p>Description {{ $task->description }}</p>
<a href="{{ route('task.marque.finish', ['task' => $task->id]) }}">Marquer cette tache comme terminée</a><br>
<a href="{{ route('task.edit', ['task' => $task->id]) }}">Voir plus</a>

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
