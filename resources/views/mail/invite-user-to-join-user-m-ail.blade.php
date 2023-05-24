<x-mail::message>
# Vous avez reçu une invitation de rejoindre un groupe

<h6>Groupe: {{ $group->name }}</h6><br>
<p>Description {{ $group->description }}</p><br>
<p>Auteur {{ $group->user->name }}</p><br>

<a href="{{ route('group.attach.user', ['group' => $group->id, 'user' => Auth::id() ]) }}">Rejoindre le groupe</a><br><br>

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
