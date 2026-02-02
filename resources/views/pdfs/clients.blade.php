
@extends('pdfs.layouts.layout-export')

@section('title', " Client")

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>Code</strong></th>
            <th><strong>nom</strong></th>
            <th><strong>Type Client</strong></th>
            <th><strong>Telephone</strong></th>
            <th><strong>Modalite Paiement</strong></th>
            <th><strong>Status</strong></th>

        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                <td >{{ ucfirst( $data[$i]['code'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['type_client']['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['telephone'] ) }}</td>
                <td >{{ $data[$i]['modalite_paiement'] ? ucfirst( $data[$i]['modalite_paiement']['nom'] ) :'--' }}</td>
                <td >{{ ucfirst( $data[$i]['status_fr'] ) }}</td>
                </tr>
            @endfor
        </tbody>
    </table>
@endsection
