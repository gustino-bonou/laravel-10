<x-mail::message>
# @if ($task->parseDateInCarbon($task->finish_at)->isSameDay(now()) && $task->finished_at === null && $task->beginned_at !== null)
Cette tache devrait terminer aujourd'hui <br><br>
<a href="{{ route('task.marque.finish', ['id' => $task->id])}}">Marquer comme terminée ?</a> <br><br>


@elseif ($task->parseDateInCarbon($task->begin_at)->isSameDay(now()) && $task->beginned_at == null)
Cette tache devrait demarrer aujourd'hui <br><br>
<a href="{{ route('task.marque.begin', ['id' => $task->id])}}">  Marquer comme démarrée ? </a> 
@endif

Task id: {{ $task->id }}
Tache: {{$task->name}} <br><br>
Decription: {{$task->description}} <br><br>

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
