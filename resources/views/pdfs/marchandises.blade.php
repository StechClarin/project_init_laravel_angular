
@extends('pdfs.layouts.layout-export')

@section('title', " Marchandises")

@section('content')

    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>Libellé</strong></th>
            <th><strong>Réference</strong></th>
            <th><strong>Nomenclature Douanière</strong></th>
            <th><strong>Type de Marchandise</strong></th>
            <th><strong>Marque</strong></th>
            <th><strong>Modele</strong></th>
            <th><strong>Energie</strong></th>
        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                <td >{{ ucfirst( $data[$i]['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['reference'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['nomenclature_douaniere']['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['type_marchandise']['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['marque']['nom']  ?? '--') }}</td>
                <td >{{ ucfirst( $data[$i]['modele']['nom']  ?? '--') }}</td>
                <td >{{ ucfirst( $data[$i]['energie']['nom'] ?? '--') }}</td>
                </tr>
            @endfor
        </tbody>
    </table>
@endsection
