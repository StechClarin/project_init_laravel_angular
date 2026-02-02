
<h4 class="text-center">BON COMMANDES</h4>

{{-- @if(isset($data['date_start_fr']) && isset($data['date_end_fr']))
    <h4 class="text-center"><u>PERIODE:</u> Du {{$data['date_start_fr']}} Au {{$data['date_end_fr']}} </h4>
@endif
@if(isset($data['libelleDepot']))
    <h4 class="text-center"><u>DEPOT:</u> <span class="text-uppercase">{{$data['libelleDepot']}}</span> </h4>
@endif --}}
{{-- @if(isset($data['produit'])) --}}
    <h4 class="text-center">

        {{-- <span class="text-uppercase">{{$data['produit']->designation_fr}}</span> --}}
        <span class="text-uppercase"><b>CODE : </b>{{$data['code']}}</span> -------
        <span class="text-uppercase"><b>DATE : </b>{{$data['date_commande_fr']}}</span> -------
        <span class="text-uppercase"><b>DEVISE : </b>{{$data['libelle_devise']}}</span>
    </h4>
{{-- @endif --}}
<br><br>
<div>
    {{-- @php
        $total_entree = 0;
        $total_sortie = 0;
    @endphp --}}
    @php
        $total = 0
    @endphp
    <table class="table">
        <tr class="tr">
            <th>Code</th>
            <th>Désignation</th>
            <th>Unite</th>
            <th>Quantité Col.</th>
            <th>Quantité Unit.</th>
            <th>P.U HT</th>
            <th>{{ __('customlang.total') }}</th>
        </tr>
        @foreach($data['detailCommandes'] as $dt)
            <tr>
                <td class="td text-left">{{$dt["produit"]["code"]}}</td>
                <td class="td text-left">{{$dt["produit"]["designation_fr"]}}</td>
                <td class="td text-left">{{$dt["produit"]["uniteMesure"]["libelle"]}}</td>
                <td class="td text-left">{{$dt["quantite_colis"] == 0 ? '0' : $dt["quantite_colis"]}}</td>
                <td class="td text-left">{{$dt["quantite_unitaire"]}}</td>
                <td class="td text-left">{{Prix_en_monetaire($dt["prix_achat_hors_ttc"])}}</td>
                <td class="td text-left">{{Prix_en_monetaire($dt["prix_achat_hors_ttc"] * $dt["quantite_unitaire"])}}</td>
            </tr>
            @php
                $total += $dt["prix_achat_hors_ttc"] * $dt["quantite_unitaire"]
            @endphp
        @endforeach
        <tr class="tr">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><b>MONTANT HT</b></td>
            <td class="td">{{Prix_en_monetaire($total)}}</td>
        </tr>
    </table>

    {{-- @foreach($data['data'] as $key => $group)
        @if(count($group) > 0)
            @php
                $sous_total_entree = 0;
                $sous_total_sortie = 0;
            @endphp
            <h4 class="text-uppercase">
                <u>{{$key}}</u>
            </h4>
            <table class="table">
                <tr class="tr">
                    <th class="th">Date</th>
                    <th class="th">OBSERVATIONS</th>
                    <th class="th text-center">ENTREE</th>
                    <th class="th text-center">SORTIE</th>
                </tr>
                @foreach($group as $d)
                    <tr class="tr">
                        <td class="td text-center">{{Carbon\Carbon::parse($d->dateop)->format('d/m/Y \à h:i')}}</td>
                        <td class="td text-left">{{$d->titre}}</td>
                        @if($d->is_entree)
                            <td class="td">{{$d->quantite_unitaire}}</td>
                            <td class="td">0</td>
                        @else
                            <td class="td">0</td>
                            <td class="td">{{$d->quantite_unitaire}}</td>
                        @endif
                        @php
                            if ($d->is_entree)
                                $sous_total_entree += $d->quantite_unitaire;
                            else
                                $sous_total_sortie += $d->quantite_unitaire;
                        @endphp
                    </tr>
                @endforeach
                <tr class="tr">
                    <td></td>
                    <td>TOTAL</td>
                    <td class="td">{{$sous_total_entree}}</td>
                    <td class="td">{{$sous_total_sortie}}</td>
                </tr>
            </table>
        @endif
        @php
            $total_entree += $sous_total_entree;
            $total_sortie += $sous_total_sortie;
        @endphp
    @endforeach --}}
</div>

<br>
<p class="text-right">
    {{-- <b><u>TOTAL DES ENTREES :</u></b> {{$total_entree}}
    <b><u>TOTAL DES SORTIES :</u></b> {{$total_sortie}} --}}
</p>
<br><br>
