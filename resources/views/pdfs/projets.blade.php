
@extends('pdfs.layouts.layout-export')

@section('title', "Projets")

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>code</strong></th>
            <th><strong>nom</strong></th>
            <th><strong>type de projet </strong></th>
            <th><strong>client</strong></th>
            <th><strong>date_debut</strong></th>
            <th><strong>date_cloture</strong></th>
            {{-- <th><strong>date de prise de fonction</strong></th> --}}

        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                <td >{{ ucfirst( $data[$i]['code'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['type_projet']['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['client']['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['date_debut'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['date_cloture'] ) }}</td>
                {{-- <td >{{ ucfirst( $data[$i]['date_embauche'] ) }}</td> --}}
                </tr>
            @endfor
        </tbody>
    </table>
@endsection
