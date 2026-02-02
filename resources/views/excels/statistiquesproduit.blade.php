<div>

    <div class="ph20">
        <div class="titre">Statistiques Produit</div>
        <br>
        <br>
    </div>
    <br>
    <br>
    <table class="table">
        <tr class="tr">
            <th class="th">Code</th>
            <th class="th">Code Fournisseur</th>
            <th class="th">Désignation Fr</th>
            <th class="th">Désignation En</th>
            <th class="th">Etat</th>
            <th class="th">Colisage</th>
            <th class="th">Unité de mesure</th>
            <th class="th">PA</th>
            <th class="th">PR</th>
            <th class="th">Marge val.</th>
            <th class="th">Marge %</th>
            @foreach($typeprixventes as $item)
            <th class="th">{{$item["libelle"]}}</th>
            @endforeach
            <th class="th">Famille</th>
            <th class="th">Sous-famille %</th>
            <th class="th">QTT Stock</th>
            <th class="th">QTT en commande</th>
            <th class="th">Min / Max</th>
            @if(count($data) > 0)
                @foreach($data[0]['qteCmdByMonth'] as $qteCmdByMonth)
                    <th class="th">{{$qteCmdByMonth["qteBc"]}}</th>
                @endforeach
            @endif
        </tr>
        @foreach($data as $db)
            <tr class="tr">
                <td class="td text-left">{{$db["code"]}}</td>
                <td class="td text-left">{{$db["code_fournisseur"]}}</td>
                <td class="td text-left">{{$db["designation_fr"]}}</td>
                <td class="td text-left">{{$db["designation_en"]}}</td>
                <td class="td text-left">{{$db["etat"]}}</td>
                <td class="td">{{$db["quantite_colis"]}}</td>
                <td class="td">{{$db["uniteMesure"]["libelle"]}}</td>
                <td class="td">
                    @if(\App\Models\Outil::isAuthorize())
                        {{$db["prix_achat_off"]}}
                    @else
                        {{$db["prix_achat"]}}
                    @endif
                </td>
                <td class="td">
                    @if(\App\Models\Outil::isAuthorize())
                        {{$db["prix_revient_off"]}}
                    @else
                        {{$db["prix_revient"]}}
                    @endif
                </td>
                <td class="td">
                    @if(\App\Models\Outil::isAuthorize())
                        {{$db["marge_off"]}}
                    @else
                        {{$db["marge"]}}
                    @endif
                </td>
                <td class="td">
                    @if(\App\Models\Outil::isAuthorize())
                        {{$db["marge_pourcent_off"]}}
                    @else
                        {{$db["marge_pourcent"]}}
                    @endif
                </td>
                @foreach($db["prixVentes"] as $key => $ss_item)
                    <td class="td">
                        {{$ss_item["prix_vente"]}}
                    </td>
                @endforeach
                @foreach($typeprixventes as $key => $ss_item)
                    @if($key>=count($db["prixVentes"]))
                        <td class="td">
                            0
                        </td>
                    @endif
                @endforeach
                <td class="td">{{$db["famille"]["libelle"]}}</td>
                <td class="td">{{isset($db["sousfamille"]) ? $db["sousfamille"]["libelle"] : null}}</td>
                <td class="td">{{$db["qte"]}}</td>
                <td class="td">{{$db["qte_commande"]}}</td>
                <td class="td">{{$db["seuil_min"]}} / {{$db["seuil_max"]}}</td>
                @foreach($db['qteCmdByMonth'] as $qteCmdByMonth)
                    <td class="td">{{$qteCmdByMonth["qteBc"]}}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
</div>
