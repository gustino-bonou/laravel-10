<x-mail::message>
# Tache à écheance proche

Cette tache est proche de son écheance <br><br>

Tache: {{$task->name}}<br><br>
Description: {{ $task->description}}<br><br>
Deadline: {{ $task->finish_at }}<br><br>

<a href="{{ route('task.edit', ['task'=>$task->id])}}">Voir plus</a><br><br>

<a href="{{ route('task.notifiable', ['tache' => $task->id])}}">Ne plus recevoir de notifications pour cette tache</a><br><br>


<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
