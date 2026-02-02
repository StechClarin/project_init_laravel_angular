
@extends('pdfs.layouts.layout-export')

@section('title', "Contacts")

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>nom</strong></th>
            <th><strong>prenom</strong></th>
            <th><strong>Telephone</strong></th>
            <th><strong>email</strong></th>

        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                <td >{{ ucfirst( $data[$i]['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['prenom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['telephone'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['email'] ) }}</td>
                </tr>
            @endfor
        </tbody>
    </table>
@endsection
