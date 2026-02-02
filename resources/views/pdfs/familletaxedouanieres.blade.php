
@extends('pdfs.layouts.layout-export')

@section('title', " Famille Taxe Douanière")

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>Code</strong></th>
            <th><strong>Nom</strong></th>  
            <th><strong>Nbre de taxe douaniere</strong></th>  
        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                <td >{{ ucfirst( $data[$i]['code'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['nom'] ) }}</td>
                <td >{{ ucfirst( $data[$i]['nbre_familletaxedouaniere'] ) }}</td>
                </tr>
            @endfor
        </tbody>
    </table>
@endsection
