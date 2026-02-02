
@extends('pdfs.layouts.layout-export')

@section('title', " AVANCE SUR SALAIRE")

@section('content')
    <table class="table table-bordered w-100" align="center">
        <tr style="font-size: 1.2em;">
            <th><strong>Date</strong></th>
            <th><strong>Employe</strong></th>
            <th><strong>Montant</strong></th>
            <th><strong>Restant</strong></th>
            <th><strong>Statut</strong></th>
            <th><strong>Etat</strong></th>

        </tr>
        <tbody>
            @foreach($data as $item)  
                <tr align="center">  
                    <td>{{ ucfirst($item['date_fr']) }}</td>  
                    <td>{{ ucfirst($item['employe']['nom']) }}</td>  
                    <td>{{ ucfirst($item['montant']) }}</td>  
                    
                    @if(isset($item['remboursements'][0]))
                        <td>{{ $item['remboursements'][0]['restant'] }}</td>
                    @elseif(!isset($item['remboursements'][0]['restant']))
                        <td>--</td>
                    @endif

                    {{-- Autres conditions --}}  
                    @if($item['etat'] == 0)  
                        <td class="badge badge-pill badge-danger">Non remboursé</td>  
                    @elseif($item['status'] == 1)  
                        <td class="badge badge-warning">Partiellement remboursé</td>  
                    @else  
                        <td class="badge badge-success">Remboursé</td>  
                    @endif  

                    @if($item['status'] == 0)  
                        <td class="badge badge-pill badge-warning">En attente</td>  
                    @elseif($item['status'] == 1)  
                        <td class="badge badge-danger">Non validée</td>  
                    @else  
                        <td class="badge badge-success">Validée</td>  
                    @endif  
                </tr>  
            @endforeach  
        </tbody>
    </table>
@endsection
