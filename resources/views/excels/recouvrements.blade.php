<h2>
    <b>Recouvrements</b>
</h2>
<br/><br/>
<table class="table table-bordered">
    <tr class="tr">
        <th class="th">Code</th>
        <th class="th">Date</th>
        <th class="th">Client</th>
        <th class="th">Echéance</th>
        <th class="th">Retard/Avance</th>
        <th class="th">Total HT</th>
        <th class="th">Total TTC</th>
        <th class="th">Déja Payé</th>
        <th class="th">Restant</th>
        <th class="th">Solde</th>
    </tr>
    @foreach($data as $db)
        <tr class="tr" >
            <td class="td">{{$db["code"]}}</td>
            <td class="td">{{$db["datefacturei_fr"]}}</td>
            <td class="td">{{$db["nom_client"]}}</td>
            <td class="td">{{$db["date_echeance_fr"]}}</td>
            @php
                $today = Carbon\Carbon::now();
                $date = Carbon\Carbon::parse($db["date_echeance"]);
            @endphp
            <td class="td">{{$db["avance_retard"]}}</td>
            <td class="td">{{Prix_en_monetaire($db["total"])}}</td>
            <td class="td">{{Prix_en_monetaire($db["totalttc"])}}</td>
            <td class="td">{{Prix_en_monetaire($db["dejapayei"])}}</td>
            @php
                $rest = ($db["totalNet"] - $db["dejapayei"]);
            @endphp
            <td class="td">{{Prix_en_monetaire($rest)}}</td>
            @php
                $val = '';
                if ($db["dejapayei"] == 0)
                {
                    // Aucun reglement
                    $val = 'Aucun';
                }
                else if ($rest == 0)
                {
                    // Totalment soldé
                    $val = 'Total';
                }
                else
                {
                    // Partiellement soldé
                    $val = 'Partiel';
                }
            @endphp
            <td class="td">{{$val}}</td>
        </tr>
    @endforeach
</table>