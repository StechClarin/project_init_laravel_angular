
@extends('pdfs.layouts.layout-export')

@section('title', "Devises")

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>Nom</strong></th>
            <th><strong>Signe</strong></th>
            <th><strong>Cours</strong></th>
            <th><strong>Unité</strong></th>
            <th><strong>Précision</strong></th>
            <th><strong>Devise de base	</strong></th>
        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                <td >{{ ucfirst( $data[$i]['nom'] ) }}</td>
                <td >{{ $data[$i]['signe']  }}</td>
                <td >{{ $data[$i]['cours']}}</td>
                <td >{{ $data[$i]['unite']}}</td>
                <td >{{ $data[$i]['precision']}}</td>
                <td >{{ ucfirst( $data[$i]['devise_base']==1 ? 'Oui' :'Non' ) }}</td>

                </tr>
            @endfor
        </tbody>
    </table>
@endsection
