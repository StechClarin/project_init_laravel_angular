
@extends('pdfs.layouts.layout-export')

@section('title', " Depenses")

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>Nom</strong></th>
            <th><strong>Type de depense</strong></th>
            <th><strong>Montant</strong></th>
            <th><strong>description</strong></th>

        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                <td >{{ ucfirst( $data[$i]['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['typedepense']['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['montant'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['description'] ) }}</td>
                </tr>
            @endfor
        </tbody>
    </table>
@endsection
