
@extends('pdfs.layouts.layout-export')

@section('title', " Entrepots")

@section('content')


    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>Libellé</strong></th>
            <th><strong>Nº Douanière</strong></th>
            <th><strong>Type</strong></th>
            <th><strong>Appartenance</strong></th>
            <th><strong>Statut</strong></th>
        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                <td >{{ ucfirst( $data[$i]['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['num_id_douaniere'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['type_entrepot']['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['appartenance']==1 ? 'Oui':'Non' ) }}</td>
                <td >{{ ucfirst( $data[$i]['status']==1 ? 'Oui':'Non' ) }}</td>
                </tr>
            @endfor
        </tbody>
    </table>
@endsection
