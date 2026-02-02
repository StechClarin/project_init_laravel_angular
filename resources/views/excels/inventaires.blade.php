<div>
    <div class="ph20">
        <div class="titre">Code : <span class="titre-text fbold">{{$data['data'][0]["depot"]["code"]}}</span></div>
        <br>
        <div class="titre">Depot : <span class="titre-text fbold">{{$data['data'][0]["depot"]["libelle"]}}</span></div>
        <br>
        <div class="titre">Date : <span class="titre-text">{{Carbon\Carbon::parse($data['data'][0]["date_inventaire"])->format('d/m/Y')}}</span></div>
        <br>
        <div class="titre">N° : <span class="titre-text">{{$data['data'][0]["code"]}}</span></div>
        <br>
    </div>
    <br>
    <br>
    <table class="table">
        <tr class="tr">
            <th class="th">Code</th>
            <th class="th">Désignation</th>
            <th class="th">QTT COL. Stock</th>
            <th class="th">QTT UNIT. Stock</th>
            <th class="th">QTT COL. Inv</th>
            <th class="th">QTT UNIT Inv</th>
            <th class="th">Unite</th>
        </tr>
        @foreach($data['data'][0]["detail_inventaires"] as $db)
            <tr class="tr">
                <td class="td text-left">{{$db["produit"]["code"]}}</td>
                <td class="td text-left">{{$db["produit"]["designation_fr"]}}</td>
                <td class="td">{{$db["quantite_colis_stock"]}}</td>
                <td class="td">{{$db["quantite_unitaire_stock"]}}</td>
                <td class="td">{{$db["quantite_colis_inv"]}}</td>
                <td class="td">{{$db["quantite_unitaire_inv"]}}</td>
                <td class="td">{{$db["produit"]["uniteMesure"]["libelle"]}}</td>
            </tr>
        @endforeach
    </table>
</div>
