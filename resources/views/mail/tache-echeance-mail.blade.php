<x-mail::message>
# Cette tache est à écheance proche 

<h6>Tache: {{ $task->name }}</h6> <br><br>
<p>Description {{ $task->description }}</p><br><br>
    
<a href="{{ route('task.edit', ['task' => $task->id]) }}">Voir plus</a><br><br>

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
