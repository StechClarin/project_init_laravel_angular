@extends('pdfs.layouts.layout-export')

@section('title', "SAV")

@section('content')
    <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
        <thead>
        <tr style="font-size: 1em; text-align: center;">
            <th style="width: 12%"><strong>Date</strong></th>
            <th style="width: 15%"><strong>Projet</strong></th>
            <th style="width: 30%"><strong>Détail</strong></th>
            <th style="width: 13%"><strong>Remonté par</strong></th>
            <th style="width: 13%"><strong>Collecté par</strong></th>
            <th style="width: 13%"><strong>Assigné à</strong></th>
            <th style="width: 10%"><strong>Status</strong></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $item)
            <tr style="font-size: 0.8em; text-align: center;">
                <td>{{ ucfirst($item['date_fr']) }}</td>
                <td>{{ ucfirst($item['projet']['nom']) }}</td>
                <td>{{ ucfirst($item['detail']) }}</td>
                <td>{{ ucfirst($item['rapporteur']) }}</td>
                <td>{{ ucfirst($item['collecteur']['name']) }}</td>
                <td>{{ ucfirst($item['assigne']['name']) }}</td>
                <td>
                    @if($item['status'] == 0)
                        <span class="badge badge-warning">En cours</span>
                    @elseif($item['status'] == 1)
                        <span class="badge badge-danger">En attente</span>
                    @else
                        <span class="badge badge-success">Cloturé</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
