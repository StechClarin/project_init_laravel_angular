@extends('pdfs.layouts.layout-export')

@section('title', 'Taxes douanière')

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>Code</strong></th>
            <th><strong>Nom</strong></th>
            <th><strong>Taux (%)</strong></th>
            <th><strong>Famille Taxe Douanière</strong></th>
            <th><strong>{{ __('customlang.taxes_douanieres') }}</strong></th>
        </tr>
        <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center">
                <td >{{ ucfirst( $data[$i]['code'] ) }}</td>
                <td >{{ $data[$i]['nom']  }}</td>
                <td >{{ $data[$i]['taux']}}</td>
                <td >{{ $data[$i]['famille_taxe_douaniere']['nom']}}</td>
                <td>
                    @for ($j = 0; $j < count($data[$i]['details']); $j++)
                        <span style="background: #d9f7ff;color:#2BA3A3;padding:0.5rem;border-radius: 5px;">{{ $data[$i]['details'][$j]['nom'] }}</span>
                    @endfor
                </td>
                </tr>
            @endfor
        </tbody>
    </table>
@endsection
