<x-mail::message>
# Invitation de rejoindre un groupe

Vous avez récu une invitation de rejoindre un groupe de travail <br><br>

Information sur le groupe groupe  <br>

Groupe: {{ $group->name }} <br>
Decritpion: {{ $group->description }}<br>
Auteur: {{ $group->user->name }} <br><br>

<a href="{{ route('group.attach.user', ['group' => $group->id, 'user' => $user->id])}}">REjoindre le groupe</a> <br><br>

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
