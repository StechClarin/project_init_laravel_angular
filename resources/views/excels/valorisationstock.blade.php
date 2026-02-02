
<h2 class="text-center">Stock valorise des produits avec <span class="text-uppercase">{{$data["libellePrix"]}}</span></h2>
@if(isset($data['libelleDepot']))
    <h3 class="text-center"><u>DEPOT:</u> <span class="text-uppercase">{{$data['libelleDepot']}}</span> </h3>
@endif
<br><br>
<div>
    @php
        $total = 0
    @endphp
    @foreach($data['data'] as $group)
        @if(count($group) > 0)
            @php
                $sous_total = 0
            @endphp
            <h4 class="text-uppercase">
                <u>FAMILLE :</u>
                @if(isset($group[0]['id_famille']))
                    <span>{{$group[0]['famille']["libelle"]}}</span>
                @elseif(isset($group[0]['id_sous_famille']))
                    <span>{{$group[0]['sousFamille']['parent']["libelle"]}}</span>
                @endif
            </h4>
            <table class="table">
                <tr class="tr">
                    <th class="th">Ref.</th>
                    <th class="th">Designation</th>
                    <th class="th text-center">UNITE</th>
                    <th class="th text-center">Stock</th>
                    <th class="th text-center"><span class="text-uppercase">{{$data["libellePrix"]}}</span></th>
                    <th class="th text-center">TOTAL</th>
                </tr>
                @foreach($group as $d)
                <tr class="tr">
                    <td class="td text-left">{{$d["code"]}}</td>
                    <td class="td text-left">{{$d["designation_fr"]}}</td>
                    <td class="td">{{$d["uniteMesure"]["libelle"]}}</td>
                    <td class="td">{{$d["qte"]}}</td>
                    <td class="td">{{Prix_en_monetaire($d["prix_valorise"])}}</td>
                    <td class="td">{{$d["valorisation"]}}</td>
                    @php
                        $sous_total += $d["valorisation"]
                    @endphp
                </tr>
                @endforeach
            </table>
            <p class="text-right">
                <b><i><u>TOTAL :</u></i></b> {{Prix_en_monetaire($sous_total)}}
            </p>
            <br><br>
        @endif
        @php
            $total += $sous_total
        @endphp
    @endforeach
</div>

<br>
<p class="text-right">
    <b><u>TOTAL :</u></b> {{Prix_en_monetaire($total)}}
</p>
<br><br>
