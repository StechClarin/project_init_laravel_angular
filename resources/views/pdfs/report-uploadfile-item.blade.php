@extends('pdfs.layouts.layout')
@section('content')
    <h2 class="text-center text-uppercase">{{$title}}</h2>

    <div class="ph20">
        <h4 class="text-uppercase">
            <u>Traité(s):</u> <strong>{{$totals['toUpload']}}</strong><br><br>
            <u>Importé(s):</u> <strong>{{$totals['upload']}}</strong><br><br>
            <u>Non importé(s):</u> <strong>{{ ($totals['toUpload'] - $totals['upload']) }}</strong><br><br>
        </h4>
    </div>

    @if(count($reports) > 0)
        <table class="table">
            <thead>
                <tr class="tr">
                    @foreach(array_keys($reports[0]) as $column)
                        <th class="th text-center">{{$column}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $key => $report)
                    <tr class="tr">
                        @foreach(array_keys($reports[$key]) as $column)
                            <td class="td">{{$report[$column]}}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
