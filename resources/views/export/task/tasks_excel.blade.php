<table class="table table.striped">
    <thead>
        <tr class="table-entete bg-gray-900">
            <th class="">Tache</th>
            <th class="">Description</th>
            <th>Démarrage prevu</th>
            <th>Demarrage effectif</th>
            <th>Fin  prevue</th>
            <th>Fin Effective</th>
            <th>Niveau</th>
            <th class="text-end">Actions</th>

        </tr>
    </thead>
    <tbody>

            <tr class="">
                
                <td>{{ $tache->name }}</td>
                <td>{{ $tache->description }}</td>
                <td>@if ($tache->beginned_at == null) Non démarrée

                    @else   

                    {{ $tache-> getDate($tache->begin_at) }} 
                    
                @endif</td>
                <td>{{ $tache->getDate($tache->beginned_at)}}</td>
                <td>{{ $tache->getDate($tache->finish_at) }}</td>
                <td>@if ($tache->finished_at == null) Non Terminée

                    @else   

                    {{ $tache-> getDate($tache->finished_at) }} 
                    
                @endif</td>

                <td class="font-weight-bold @if($tache->level == 'low') text-secondary  @elseif($tache->level == 'high') text-danger @elseif($tache->level == 'medium') text-warning @endif">{{ Str::ucfirst($tache->level) }}</td>

            </tr>


    </tbody>
</table>