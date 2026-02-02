@extends('pdfs.layouts.layout-export')

@section('title', "Bilan des tâches")

@section('content')

@php
// Données brutes
$bilantaches = $data['data']['bilantaches'] ?? [];

// Initialiser les totaux par personnel
$groupedData = [];

foreach ($bilantaches as $item) {
    $personnel = $item['personnel'];
    $id = $personnel['id'];
    $nomComplet = ucfirst($personnel['nom'] . ' ' . $personnel['prenom']);

    // Durée chiffrage (prévisionnelle) en minutes
    $chiffrage = $item['tacheassigne']['tachefonctionnalite']['duree'] ?? null;
    $chiffrageMinutes = 0;
    if ($chiffrage) {
        [$h, $m] = explode(':', $chiffrage);
        $chiffrageMinutes = ($h * 60) + $m;
    }

    // Durée exécution (réelle) en minutes
    $execMinutes = $item['tacheassigne']['duree'] ?? 0;

    if (!isset($groupedData[$id])) {
        $groupedData[$id] = [
            'nom_complet' => $nomComplet,
            'nombre_taches' => 0,
            'duree_chiffrage' => 0,
            'duree_execution' => 0,
        ];
    }

    $groupedData[$id]['nombre_taches']++;
    $groupedData[$id]['duree_chiffrage'] += $chiffrageMinutes;
    $groupedData[$id]['duree_execution'] += $execMinutes;
}

// Fonction pour formater en HH:MM
function formatMinutesToHHMM($minutes) {
    $hours = floor($minutes / 60);
    $mins = $minutes % 60;
    return sprintf('%02d:%02d', $hours, $mins);
}
@endphp

<table class="table table-bordered w-100 text-center">
    <thead>
        <tr style="font-size: 1.2em;">
            <th>Personnel</th>
            <th>Nombre de tâches</th>
            <th>Durée totale chiffrage</th>
            <th>Durée totale exécution</th>
            <th>Efficience moyenne</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($groupedData as $bilan)
        @php
            $efficience = $bilan['duree_execution'] > 0
                ? round(($bilan['duree_chiffrage'] / $bilan['duree_execution']) * 100, 2) . '%'
                : '0%';
        @endphp
        <tr>
            <td>{{ ucfirst($item['personnel']['nom']) }}</td>
            <td>{{ $bilan['nombre_taches'] }}</td>
            <td>{{ formatMinutesToHHMM($bilan['duree_chiffrage']) }} ({{ $bilan['duree_chiffrage'] }} min)</td>
            <td>{{ formatMinutesToHHMM($bilan['duree_execution']) }} ({{ $bilan['duree_execution'] }} min)</td>
            <td>{{ $efficience }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
