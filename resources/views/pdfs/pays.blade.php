@extends('pdfs.layouts.layout-export')

@section('title', " Client")

@section('content')
<table class="table table-bordered w-100" align="center">
    <tr style="font-size: 1.2em;">
        <th><strong>Nom</strong></th>
        <th><strong>CEDEAO</strong></th>
    </tr>
    <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
            <td>{{ ucfirst( $data[$i]['nom'] ) }}</td>
            <td>{{ ucfirst($data[$i]['cedeao'] ? 'oui' : 'non') }}</td>
            </tr>
            @endfor
    </tbody>
</table>
@endsection