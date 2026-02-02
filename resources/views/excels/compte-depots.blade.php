<h2>
    <b>Compte depots</b>
</h2>
<br/><br/>
<table class="table table-bordered">
    <tr class="tr">
        <th class="th">Code</th>
        <th class="th">Dépot</th>
        <th class="th">Débit</th>
        <th class="th">Crédit</th>
        <th class="th">Solde</th>
    </tr>
    @foreach($data['data'] as $d)
        <tr class="tr">
            <td class="td">{{$d["code"]}}</td>
            <td class="td">{{$d["libelle"]}}</td>
            <td class="td">{{Prix_en_monetaire($d["debit"])}}</td>
            <td class="td">{{Prix_en_monetaire($d["credit"])}}</td>
            <td class="td">{{Prix_en_monetaire($d["solde"])}}</td>
        </tr>
    @endforeach
</table>