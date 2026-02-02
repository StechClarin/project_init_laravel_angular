
@extends('pdfs.layouts.layout-export')

@section('title', " Categories de depense")

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>nom</strong></th>
            <th><strong>decription</strong></th>
            

        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                <td >{{ ucfirst( $data[$i]['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['description'] ) }}</td>

                </tr>
            @endfor
        </tbody>
    </table>
@endsection
