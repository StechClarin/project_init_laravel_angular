
<h4 class="text-center">DÉBIT / CRÉDIT DE CLIENT</h4>

@if(isset($data['date_start_fr']) && isset($data['date_end_fr']))
    <h4 class="text-center"><u>PERIODE:</u> Du  {{$data['date_start_fr']}} Au {{$data['date_end_fr']}} </h4>
@endif
@if(isset($data['client']))
    <h4 class="text-center">
        <u>CLIENT:</u>
        <span class="text-uppercase">{{$data['client']->nom_complet}}</span>
    </h4>
@endif
<br><br>
<div>
    @php
        $total_debit = 0;
        $total_credit = 0;
    @endphp
    @foreach($data['data'] as $key => $group)
        @if(count($group) > 0)
            @php
                $sous_total_debit = 0;
                $sous_total_credit = 0;
            @endphp
            <h4 class="text-uppercase">
                <u>{{$key}}</u>
            </h4>
            <table class="table">
                <tr class="tr">
                    <th class="th">Date</th>
                    <th class="th">OBSERVATIONS</th>
                    <th class="th text-center">DÉBIT</th>
                    <th class="th text-center">CRÉDIT</th>
                </tr>
                @foreach($group as $d)
                    <tr class="tr">
                        <td class="td text-center">{{Carbon\Carbon::parse($d->dateop)->format('d/m/Y \à h:i')}}</td>
                        <td class="td text-left">{{$d->titre}}</td>
                        @if($d->is_debit)
                            <td class="td">{{$d->total}}</td>
                            <td class="td">0</td>
                        @else
                            <td class="td">0</td>
                            <td class="td">{{$d->total}}</td>
                        @endif
                        @php
                            if ($d->is_debit)
                                $sous_total_debit += $d->total;
                            else
                                $sous_total_credit += $d->total;
                        @endphp
                    </tr>
                @endforeach
                <tr class="tr">
                    <td></td>
                    <td>TOTAL</td>
                    <td class="td">{{$sous_total_debit}}</td>
                    <td class="td">{{$sous_total_credit}}</td>
                </tr>
            </table>
        @endif
        @php
            $total_debit += $sous_total_debit;
            $total_credit += $sous_total_credit;
        @endphp
    @endforeach
</div>

<br>
<p class="text-right">
    <b><u>TOTAL DES DEBITS :</u></b> {{$total_debit}}
    <b><u>TOTAL DES CRÉDITS :</u></b> {{$total_credit}}
</p>
<br><br>
