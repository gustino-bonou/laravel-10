<x-mail::message>
# Invitation de rejoindre un groupe

Vous avez récu une invitation de rejoindre un groupe de travail <br><br>

Information par rapport au groupe  <br><br>

Groupe: {{ $group->name }} <br>
Decritpion: {{ $group->description }}<br>
Auteur: {{ $group->user->name }} <br><br>

<a href="{{ route('group.attach.user', ['group' => $group->id, 'user' => $user->id])}}">Accepter</a> <br><br>

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
