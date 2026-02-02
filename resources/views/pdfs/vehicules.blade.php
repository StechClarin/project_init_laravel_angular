
@extends('pdfs.layouts.layout-export')

@section('title', " Vehicules")

@section('content')

    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>Libellé</strong></th>
            <th><strong>Immatriculation</strong></th>
            <th><strong>Nomenclature Douanière</strong></th>
            <th><strong>Marque</strong></th>
            <th><strong>Modele</strong></th>
            <th><strong>Energie</strong></th>
        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                <td >{{ ucfirst( $data[$i]['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['immatriculation'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['nomenclature_douaniere']['nom'] ?? '--' ) }}</td>
                <td >{{ ucfirst( $data[$i]['marque']['nom']  ?? '--') }}</td>
                <td >{{ ucfirst( $data[$i]['modele']['nom']  ?? '--') }}</td>
                <td >{{ ucfirst( $data[$i]['energie']['nom'] ?? '--') }}</td>
                </tr>
            @endfor
        </tbody>
    </table>
@endsection
