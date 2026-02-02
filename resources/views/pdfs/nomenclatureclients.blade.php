
@extends('pdfs.layouts.layout-export')

@section('title', "Nomenclatures de client")

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>Nom</strong></th>
            <th><strong>Nbre Client</strong></th>
        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                <td >{{ ucfirst( $data[$i]['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['nbre_client'] ) }}</td>
                </tr>
            @endfor
        </tbody>
    </table>
@endsection
