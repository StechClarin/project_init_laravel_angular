
@extends('pdfs.layouts.layout-export')

@section('title', " SAV / RAPPORT ASSISTANCES")

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1em;">
            <th><strong>Date</strong></th>
            <th><strong>libelle</strong></th>
            <th><strong>Projet</strong></th>
        

        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center" style="font-size: 0.8em;">
                <td >{{ ucfirst( $data[$i]['date_fr'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['libelle']) }}</td>
                <td >{{ ucfirst( $data[$i]['projet']['nom'] ) }}</td>
            </tr>
            @endfor
        </tbody>
    </table>
@endsection
