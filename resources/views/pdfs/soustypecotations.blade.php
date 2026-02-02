

@extends('pdfs.layouts.layout-export')

@section('title', "Sous Type Cotation")

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>Nom</strong></th>
            <th><strong>Type Cotation Parent</strong></th>
        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                <td >{{ ucfirst( $data[$i]['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['type_cotation']['nom'] ) }}</td>
                </tr>
            @endfor
        </tbody>
    </table>
@endsection
