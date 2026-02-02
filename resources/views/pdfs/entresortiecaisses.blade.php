
@extends('pdfs.layouts.layout-export')

@section('title', " Entre caisse")

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>caisse</strong></th>
            <th><strong>Motif</strong></th>
            <th><strong>motant</strong></th>
            <th><strong>description</strong></th>

        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                <td >{{ ucfirst( $data[$i]['caisse']['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['motifentresortiecaisse']['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['montant'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['description'] ) }}</td>
                </tr>
            @endfor
        </tbody>
    </table>
@endsection
