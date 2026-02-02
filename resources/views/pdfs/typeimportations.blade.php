@extends('pdfs.layouts.layout-export')

@section('title', ' Type Importations')

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>Nom</strong></th>
            <th><strong>Type De Marchandise</strong></th>
            <th><strong>Type De Dossier</strong></th>
            <th><strong>Description</strong></th>
        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                <td >{{ ucfirst( $data[$i]['nom'] ) }}</td>
                <td>
                    @for ($j = 0; $j < count($data[$i]['type_marchandises']); $j++)
                        <span style="background: #d9f7ff;color:#2BA3A3;padding:0.5rem;border-radius: 5px;">{{ $data[$i]['type_marchandises'][$j]['nom'] }}</span>
                    @endfor
                </td>
                <td>
                    @for ($k = 0; $k < count($data[$i]['type_dossiers']); $k++)
                        <span style="background: #d9f7ff;color:#2BA3A3;padding:0.5rem;border-radius: 5px;">{{ $data[$i]['type_dossiers'][$k]['nom'] }}</span>
                    @endfor
                </td>
                <td >{{ ucfirst( $data[$i]['description'] ) }}</td>
                </tr>
            @endfor
        </tbody>
    </table>
@endsection
