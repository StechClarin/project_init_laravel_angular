@extends('pdfs.layouts.layout-export')

@section('title', "Pointage")

@section('content')

@php
$entries = collect($data);

// Heures de référence pour le calcul du retard
$heureDebutJournee = Carbon\Carbon::createFromTimeString('08:45:00');
$heureDebutSaturday = Carbon\Carbon::createFromTimeString('09:00:00');


// Fonction d'aide pour formater les minutes en HH:MM
function formatMinutesToHHMM($minutes) {
if (!is_numeric($minutes) || $minutes < 0) {
    return '00:00' ;
    }
    $hours=floor($minutes / 60);
    $mins=$minutes % 60;
    return sprintf('%02d:%02d', $hours, $mins);
    }

    // Ajout de la logique de calcul de retard et de regroupement
    $groupedData=$entries->groupBy('personnel.id')->map(function ($items, $personnelId) use ($heureDebutJournee, $heureDebutSaturday) {
    $personnelInfo = $items->first()['personnel'];

    $totalRetardsAvecJustif = 0;
    $totalRetardsSansJustif = 0;
    $bureauTotalMinutes = 0;

    foreach ($items as $item) {
    $retardMinutes = 0;

    // Détermination de l'heure de début de journée en fonction du jour de la semaine
    $dateEntree = Carbon\Carbon::parse($item['date']);
    $referenceTime = ($dateEntree->dayOfWeek === Carbon\Carbon::SATURDAY) ? $heureDebutSaturday : $heureDebutJournee;

    if (isset($item['heure_arrive'])) {
    $heureArrive = Carbon\Carbon::createFromTimeString($item['heure_arrive']);
    if ($heureArrive->greaterThan($referenceTime)) {
    $retardMinutes = $heureArrive->diffInMinutes($referenceTime);
    }
    }

    if (isset($item['justificatif']) && $item['justificatif']) {
    $totalRetardsAvecJustif += $retardMinutes;
    } else {
    $totalRetardsSansJustif += $retardMinutes;
    }

    $bureauTotalMinutes = $item['pointage']['temps_au_bureau'] ?? 0;
    $bureauTotalMinutes = is_numeric($bureauTotalMinutes) ? (int)$bureauTotalMinutes : 0;
    }

    return [
    'nom_complet' => ucfirst($personnelInfo['nom'] . ' ' . $personnelInfo['prenom']),
    'retard_avec_justif_minutes' => $totalRetardsAvecJustif,
    'retard_sans_justif_minutes' => $totalRetardsSansJustif,
    'bureau_total_minutes' => $bureauTotalMinutes,
    ];
    });

    $sortedDataSansJustif = $groupedData->sortByDesc('retard_sans_justif_minutes');
    $sortedDataAvecJustif = $groupedData->sortByDesc('retard_avec_justif_minutes');

    //$groupedByDate = $entries->groupBy(groupBy: 'date');

    $groupedByDate = $entries->groupBy('date')->sortByDesc(function ($item, $key) {
    return \Carbon\Carbon::parse($key);
    });
    // Extraction des dates pour le titre
    $dateDebut = $entries->sortBy('date')->first()['date'] ?? null;
    $dateFin = $entries->sortByDesc('date')->first()['date'] ?? null;

    $dateDebutFormatted = $dateDebut ? \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') : 'N/A';
    $dateFinFormatted = $dateFin ? \Carbon\Carbon::parse($dateFin)->format('d/m/Y') : 'N/A';
    @endphp
    <style>
        /* Styles généraux du corps et de la page */
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        /* Styles des tableaux */
        .table {
            width: 100%;
            margin-top: 1rem;
            margin-bottom: 1rem;
            border-collapse: collapse;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid rgba(0, 0, 0, 0.5);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        /* Styles spécifiques aux titres et en-têtes de tableau */
        h3 {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .bg-info {
            background-color: #17a2b8;
        }

        .bg-danger {
            background-color: #dc3545;
        }

        .text-white {
            color: #fff;
        }

        .text-center {
            text-align: center;
        }

        .w-100 {
            width: 100%;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        .p-3 {
            padding: 1rem;
        }

        /* Styles pour la table des retards par date */
        ul {
            padding-left: 20px;
            margin-bottom: 0;
        }

        li {
            margin-bottom: 5px;
        }

        /* Styles pour les en-têtes des tables de totaux */
        .table-header {
            font-size: 1.4em;
            padding: 12px;
            border: 1px solid rgba(0, 0, 0, 0.5);
        }

        .table-sub-header {
            font-size: 1.2em;
            border: 1px solid rgba(0, 0, 0, 0.5);
        }

        .table-cell-large {
            font-size: 1.2em;
        }
    </style>
    <h3 class="text-center">Rapport du {{ $dateDebutFormatted }} au {{ $dateFinFormatted }}</h3>
    <br>
    {{-- Tableau des retards par date avec ou sans justificatif --}}
    <table class="table table-bordered w-100 mt-4 text-center">
        <thead>
            <tr class="table-sub-header">
                <th>Date</th>
                <th>Avec justificatif</th>
                <th>Sans justificatif</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groupedByDate as $date => $entriesByDate)
            @php
            $avecJustif = [];
            $sansJustif = [];

            // Détermination de l'heure de début de journée en fonction du jour de la semaine
            $dateEntree = Carbon\Carbon::parse($date);
            $referenceTime = ($dateEntree->dayOfWeek === Carbon\Carbon::SATURDAY) ? $heureDebutSaturday : $heureDebutJournee;

            foreach ($entriesByDate as $entry) {
            $retardMinutes = 0;
            if (isset($entry['heure_arrive'])) {
            $heureArrive = Carbon\Carbon::createFromTimeString($entry['heure_arrive']);
            if ($heureArrive->greaterThan($referenceTime)) {
            $retardMinutes = $heureArrive->diffInMinutes($referenceTime);
            }
            }

            if ($retardMinutes > 0) {
            $personnel = $entry['personnel'] ?? null;
            if (!$personnel) continue;

            $fullName = ucfirst($personnel['nom'] . ' ' . $personnel['prenom']);
            $heureArrive = $entry['heure_arrive'] ?? 'N/A';

            if ($entry['justificatif']) {
            $avecJustif[] = [
            'nom' => $fullName,
            'heure_arrive' => $heureArrive,
            'description' => $entry['description'] ?? 'Aucune',
            ];
            } else {
            $sansJustif[] = [
            'nom' => $fullName,
            'heure_arrive' => $heureArrive,
            ];
            }
            }
            }
            @endphp

            @if (!empty($avecJustif) || !empty($sansJustif))
            <tr>
                <td class="text-center table-cell-large" style="vertical-align: top; font-weight: bold;">
                    {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                </td>
                <td style="vertical-align: top; text-align: left;">
                    <ul>
                        @foreach ($avecJustif as $info)
                        <li>
                            {{ $info['nom'] }} : {{ $info['heure_arrive'] }}
                            @if ($info['description'] && $info['description'] !== 'Aucune')
                            ({{ $info['description'] }})
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </td>
                <td style="vertical-align: top; text-align: left;">
                    <ul>
                        @foreach ($sansJustif as $info)
                        <li>
                            {{ $info['nom'] }} : {{ $info['heure_arrive'] }}
                        </li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>

    <br>
    <hr>
    <br>

    {{-- Tableau des totaux retard par personnel avec justificatif --}}
    <table class="table table-bordered table-striped w-100 text-center">
        <thead>
            <tr>
                <th colspan="3" class="bg-info text-white table-header">
                    Total des retards avec justificatif
                </th>
            </tr>
            <tr class="bg-info text-white table-sub-header">
                <th>Personnel</th>
                <th>Total des retards (HH:MM)</th>
                <th>Total des heures au bureau (HH:MM)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sortedDataAvecJustif as $personnel)
            <tr>
                <td class="table-cell-large">{{ $personnel['nom_complet'] }}</td>
                <td class="table-cell-large">{{ formatMinutesToHHMM($personnel['retard_avec_justif_minutes']) }}</td>
                <td class="table-cell-large">{{ formatMinutesToHHMM($personnel['bureau_total_minutes']) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <hr>
    <br>

    {{-- Tableau des totaux retard par personnel sans justificatif --}}
    <table class="table table-bordered table-striped w-100 text-center">
        <thead>
            <tr>
                <th colspan="3" class="bg-danger text-white table-header">
                    Total des retards sans justificatif
                </th>
            </tr>
            <tr class="bg-danger text-white table-sub-header">
                <th>Personnel</th>
                <th>Total des retards (HH:MM)</th>
                <th>Total des heures au bureau (HH:MM)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sortedDataSansJustif as $personnel)
            <tr>
                <td class="table-cell-large">{{ $personnel['nom_complet'] }}</td>
                <td class="table-cell-large">{{ formatMinutesToHHMM($personnel['retard_sans_justif_minutes']) }}</td>
                <td class="table-cell-large">{{ formatMinutesToHHMM($personnel['bureau_total_minutes']) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @endsection