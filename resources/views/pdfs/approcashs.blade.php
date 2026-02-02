
@extends('pdfs.layouts.layout-export')

@section('title', "Caisse")

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>Date</strong></th>
            <th><strong>Caisse source</strong></th>
            <th><strong>Montant</strong></th>
            <th><strong>Caisse Destinataire</strong></th>
            <th><strong>Motif</strong></th>
            <th><strong>Creer Par cloture Caisse</strong></th>
        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                <td >{{ isset($data[$i]['date_fr']) ? ucfirst( $data[$i]['date_fr'] ):'--' }}</td>
                <td >{{ isset($data[$i]['caisse_source']['nom']) ? ucfirst( $data[$i]['caisse_source']['nom'] ):'--' }}</td>
                <td >{{ isset($data[$i]['montant_fr'] ) ? ucfirst( $data[$i]['montant_fr'] ):'--' }}</td>
                <td >{{ isset($data[$i]['caisse_destinataire']['nom']) ? ucfirst( $data[$i]['caisse_destinataire']['nom'] ):'--' }}</td>
                <td >{{ isset($data[$i]['motif']) ? ucfirst( $data[$i]['motif'] ):'--' }}</td>
                <td >{{ isset($data[$i]['etat_fr']) ? ucfirst( $data[$i]['etat_fr'] ) :'--'}}</td>
                </tr>
            @endfor
        </tbody>
    </table>
@endsection
