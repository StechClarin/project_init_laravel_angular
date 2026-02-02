<h2>
    <b>Liste des prix de ventes</b>
</h2>
<br/><br/>
<table class="table table-bordered">
    <tr class="tr">
        <th class="th">Ref.</th>
        <th class="th">Designation</th>
        <th class="th">Col.</th>
        <th class="th">Unité</th>
        @foreach($data['typeprixventes'] as $tpv)
            <th class="th">{{$tpv["libelle"]}}</th>
        @endforeach
    </tr>
    @foreach($data['data'] as $d)
        <tr class="tr">
            <td class="td">{{$d["code"]}}</td>
            <td class="td">{{$d["designation_fr"]}}</td>
            <td class="td">{{$d["quantite_colis"]}}</td>
            <td class="td">{{$d["uniteMesure"]["libelle"]}}</td>
            @foreach($d["prixVentes"] as $dtpv)
                <td class="td">{{Prix_en_monetaire($dtpv["prix_vente"])}}</td>
            @endforeach
        </tr>
    @endforeach
</table>
<br/><br/>
<h2 style="text-align: center">
    <b>
        Le {{Carbon\Carbon::now()->format('d/m/Y \à h:i')}}
    </b>
</h2>