

@extends('pdfs.layouts.layout-export')
@for ($i = 0; $i < count($data); $i++)
    @if($data[$i]['noyaux_interne']['nom'] !== null)
        @section('title', "Prospection Projet Noyau")
    @else
        @section('title', "Prospection projet Sur mesure")
    @endif
@endfor

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>Date debut</strong></th>
            <th><strong>Prespect</strong></th>
            <th><strong>Nom</strong></th>
            <th><strong>Noyaux</strong></th>
            <th><strong>Commentaire</strong></th>
            <th><strong>status</strong></th>

        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                <td >{{ ucfirst( $data[$i]['date_fr'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['client']['display_text'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['noyaux_interne']['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['commentaires'] ) }}</td>
               @if($data[$i]['status'] == 0) <td >En attente</td>@endif
               @if($data[$i]['status'] == 1) <td >Non validé</td>@endif
               @if($data[$i]['status'] == 2)<td >Validé</td>@endif
                </tr>
            @endfor
        </tbody>
    </table>
@endsection
