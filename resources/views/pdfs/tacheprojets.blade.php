@extends('pdfs.layouts.layout-export')

@section('title', "Bilan d'efficience des développeurs")

@section('content')

@php
$devStats = [];

foreach ($data as $tache) {
$personnel = $tache['personnel'];
if (!$personnel) continue;

$id = $personnel['id'];
$fullName = ucfirst($personnel['nom'] . ' ' . $personnel['prenom']);

$stat = $devStats[$id] ?? [
'nom' => $fullName,
'taches_total' => 0,
'taches_terminees' => 0,
'taches_en_cours' => 0,
'duree_estimee_minutes' => 0,
'duree_reelle_minutes' => 0,
];

$stat['taches_total']++;

// Durée estimée (format HH:MM:SS)
if (!empty($tache['duree_convertie'])) {
$timeParts = explode(':', $tache['duree_convertie']);
$minutes = ($timeParts[0] ?? 0) * 60 + ($timeParts[1] ?? 0);
$stat['duree_estimee_minutes'] += $minutes;
}

if ($tache['status'] == 1 || $tache['status'] == 0) {
$stat['taches_en_cours']++;
}

if ($tache['status'] == 2) {
$stat['taches_terminees']++;

// Durée réelle (diff entre date_debut2 et date_fin2)
if ($tache['date_debut2'] && $tache['date_fin2']) {
try {
$start = \Carbon\Carbon::parse($tache['date_debut2']);
$end = \Carbon\Carbon::parse($tache['date_fin2']);
$realMinutes = $start->diffInMinutes($end);
$stat['duree_reelle_minutes'] += $realMinutes;
} catch (\Exception $e) {}
}
}

$devStats[$id] = $stat;
}

function minutesToHHMM($minutes) {
$h = floor($minutes / 60);
$m = $minutes % 60;
return sprintf('%02d:%02d', $h, $m);
}
@endphp

<h2 style="text-align: center; margin-bottom: 20px;">Bilan d'efficience par développeur</h2>

<table class="table table-bordered text-center">
    <thead class="bg-primary text-white">
        <tr>
            <th>Développeur</th>
            <th>Tâches total</th>
            <th>Tâches terminées</th>
            <th>Tâches en cours</th>
            <th>Temps estimé</th>
            <th>Temps réel</th>
            <th>Efficacité (%)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($devStats as $stat)
        @php
        $efficacite = $stat['duree_reelle_minutes'] > 0
        ? round(($stat['duree_estimee_minutes'] / $stat['duree_reelle_minutes']) * 100, 2)
        : '--';
        @endphp
        <tr>
            <td>{{ $stat['nom'] }}</td>
            <td>{{ $stat['taches_total'] }}</td>
            <td>{{ $stat['taches_terminees'] }}</td>
            <td>{{ $stat['taches_en_cours'] }}</td>
            <td>{{ minutesToHHMM($stat['duree_estimee_minutes']) }}</td>
            <td>{{ minutesToHHMM($stat['duree_reelle_minutes']) }}</td>
            <td>{{ is_numeric($efficacite) ? $efficacite . '%' : '--' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection