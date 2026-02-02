@extends('pdfs.layouts.layout-export')

@section('title', " pointage")

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            {{-- <th><strong>Code</strong></th> --}}
            <th><strong>date</strong></th>
            <th><strong>personnel</strong></th>
            <th><strong>heure d'arrive</strong></th>
            <th><strong>heure de depart</strong></th>
            <th><strong>retard</strong></th>
            <th><strong>Justificatif</strong></th>
        </tr>
    
        <tbody>
            @for ($i = 0; $i < count($data); $i++)
                <tr align="center">
                {{-- <td >{{ ucfirst( $data[$i]['code'] ) }}</td> --}}
                <td>{{ ucfirst( $data[$i]['date'] ) }}</td>
                <td>{{ ucfirst( $data[$i]['personnel']['nom'].' '.$data[$i]['personnel']['prenom']  ) }}</td>
                <td>{{ ucfirst( $data[$i]['heure_arrive'] ) }}</td>
                <td>{{ ucfirst( $data[$i]['heure_depart'] ) }}</td>
                <td>{{ ucfirst( $data[$i]['retard'] ) ? 'oui' : 'non' }}</td>
                <td>{{ ucfirst( $data[$i]['description'] ) }}</td>
                </tr>
    
                @endfor
        </tbody>
    </table>

@endsection