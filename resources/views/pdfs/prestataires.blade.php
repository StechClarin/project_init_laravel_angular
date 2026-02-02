
@extends('pdfs.layouts.layout-export')

@section('title', " Prestataire")

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>Code</strong></th>
            <th><strong>nom</strong></th>
            <th><strong>Type Prestataire</strong></th>
            <th><strong>Telephone</strong></th>
            <th><strong>Email</strong></th>
            <th><strong>Modalite Paiement</strong></th>
            <th><strong>Status</strong></th>

        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                <td >{{ ucfirst( $data[$i]['code'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['type_prestataire']['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['telephone'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['email'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['modalite_paiement']['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['status_fr'] ) }}</td>
                </tr>
            @endfor
        </tbody>
    </table>
@endsection
