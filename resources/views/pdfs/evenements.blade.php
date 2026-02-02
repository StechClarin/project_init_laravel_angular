
@extends('pdfs.layouts.layout-export')

@section('title', " evenements")

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            {{-- <th><strong>Code</strong></th> --}}
            <th><strong>date</strong></th>
            <th><strong>projet</strong></th>
            <th><strong>gravite</strong></th>
            <th><strong>personnel</strong></th>
            <th><strong>temps perdu</strong></th>
            <th><strong>mesure</strong></th>
            <th><strong>observation</strong></th>

        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                {{-- <td >{{ ucfirst( $data[$i]['code'] ) }}</td> --}}
                <td >{{ ucfirst( $data[$i]['date'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['projet']['nom']  ) }}</td>
                <td >{{ ucfirst( $data[$i]['gravite'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['personnel']['nom'].' '. $data[$i]['personnel']['prenom']  ) }}</td>
                <td >{{ ucfirst( $data[$i]['temps'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['mesure'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['observation'] ) }}</td>

                </tr>
            @endfor
        </tbody>
    </table>
@endsection
