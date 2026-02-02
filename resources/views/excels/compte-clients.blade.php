<h2>
    <b>Compte clients</b>
</h2>
<br/><br/>
<table class="table table-bordered">
    <tr class="tr">
        <th class="th">Code</th>
        <th class="th">Client</th>
        <th class="th">Débit</th>
        <th class="th">Crédit</th>
        <th class="th">Solde</th>
    </tr>
    @foreach($data['data'] as $d)
        <tr class="tr">
            <td class="td">{{$d["code"]}}</td>
            <td class="td">{{$d["nom_complet"]}}</td>
            <td class="td">{{Prix_en_monetaire(abs(round($d["totalttc"])))}}</td>
            <td class="td">{{Prix_en_monetaire(abs(round($d["dejapayei"])))}}</td>
            <td class="td">{{Prix_en_monetaire(abs(round($d["montantdu"])))}}</td>
        </tr>
    @endforeach
</table>