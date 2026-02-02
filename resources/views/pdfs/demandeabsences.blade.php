
@extends('pdfs.layouts.layout-export')

@section('title', " DEMANDES D'ABSENCE")

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>Date</strong></th>
            <th><strong>Employe</strong></th>
            <th><strong>Date debut</strong></th>
            <th><strong>Deta fin</strong></th>
            <th><strong>Heures d'absence</strong></th>
            <th><strong>Motif</strong></th>
            <th><strong>Description</strong></th>
            <th><strong>Status</strong></th>
        </tr>
        <tbody>
            @for ($i = 0; $i < count($data); $i++)
                <tr align="center">
                    <td >{{ ucfirst( $data[$i]['date_fr'] ) }}</td>
                    <td >{{ ucfirst( $data[$i]['employe']['nom'] ) }}</td>
                    <td >{{ ucfirst( $data[$i]['date_debut_fr']) }}</td>
                    <td >{{ ucfirst( $data[$i]['date_fin_fr']) }}</td>
                    <td >{{ ucfirst( $data[$i]['heure_debut']).' à '.ucfirst( $data[$i]['heure_fin'])}}</td>
                  
                    <td >{{ ucfirst( $data[$i]['motif'] ) }}</td>
                    <td >{{ ucfirst( $data[$i]['description'] ) }}</td>
                    @if($data[$i]['status']==0 )
                        <td class="badge badge-pill badge-warning">En attente</td>
                    @elseif ($data[$i]['status']==1)
                        <td class="badge badge-danger">Non validée</td>
                    @else
                        <td class="badge badge-success">Validée</td>
                    @endif
                </tr>
            @endfor
        </tbody>
    </table>
@endsection
