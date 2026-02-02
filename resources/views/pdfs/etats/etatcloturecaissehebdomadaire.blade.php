<html>
<head>
    <style>
        #entete {
            margin: 50px 30px;
        }

        table, th, td {
            border: 1px solid #585b5e;
            border-collapse: collapse;
            padding: .4rem;
        }

        th {
            font-size: 14px;
        }

        td {
            font-size: 12px;
        }

        .table {
            display: table;
            border-collapse: collapse;
            border: 1px  solid black;
            letter-spacing: 1px;
            font-size: 0.6rem;
            width: 100%;
        }

        .td, .th {
            border: 0.6px solid black;
            padding: 15px 5px;

        }

        .table-2 {
            display: table;
            border-collapse: collapse;
            border: 0px  solid black;
            letter-spacing: 1px;
            font-size: 0.65rem;
            width: 100%;
        }

        .td-2 {
            padding: 0.7rem 1rem !important;
            text-overflow: ellipsis;
            width: 20%;
        }

        .border {
            border: 0.6px solid black;
        }

        .th {
            background-color: rgb(0 154 191);
            text-transform: uppercase;
            padding: 15px 5px;
            /* color: white; */
            font-weight: 600;
        }

        .td {
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        /**
            Set the margins of the page to 0, so the footer and the header
            can be of the full height and width !
         **/
        @page {
            margin: 20px 0px;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 5.1cm;
            margin-left: 1.0cm;
            margin-right: 1.0cm;
            margin-bottom: 5cm;
            /*margin-bottom: 1.2cm;*/
            /*font-size: 1.2em;*/
            /*font: 12pt/1.5 'Raleway','Cambria', sans-serif;*/
            font-weight: 400;
            background:  #fff;
            color: black;
            -webkit-print-color-adjust:  exact;
        }

        .end-page
        {
            position:fixed;
            bottom: 0cm !important;
            left: 1cm;
            right: 1cm;
            height:1cm;
        }

        /** Define the header rules **/
        .header {
            position: fixed;
            top: 0.8cm;
            height: 2cm;
            left: 1cm;
            right: 1cm;
        }

        /** Define the footer rules **/
        .footer {
            position: fixed;
            bottom: -.1cm;
            /*bottom: -.6cm;*/
            height: .8cm;
        }

        .pagenum:before {
            content: counter(page);
        }

        #break {
            display:inline;
        }
        #break:after {
            content:"\a";
            white-space: pre;
        }

        tr{
            width: 100% !important;
        }

        #table-left td {
            padding: 5px;
            font-weight: bold;
            border-collapse: collapse;
            border-spacing: 0px;
            border-bottom: 0.5px dotted black;
            border-top: 0px;
        }

        .montant td {
            text-align: left;
            height: 15px;
            font-weight: bold;
        }

        #table-right td {
            border: 0px !important;
        }

        .montand td {
            padding: 5px;
        }

        .item-titre {
            font-weight: 600 !important;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .item-portion {
            font-weight: 600 !important;
            font-size: 15px;
            margin-bottom: 20px;
        }

        .item-border-b {
            border-bottom: 2px solid #000000;
            padding-bottom: 3px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .font-bold {
            font-weight: 700;
        }

        .font-init {
            font-weight: normal;
        }

    </style>

    <title>PDF Etat clôture hebdomadaire par période</title>
</head>
<body>
{{-- <header class="header" style="width:100%;margin-bottom: 50px !important;">
    <div  style="">
        <img style="width: 250px" src="{{asset('assets/media/logos/logo.svg')}}" alt="">
    </div>
</header> --}}

<div style="text-align:center;line-height: 22px;margin-bottom: 28px">
    <div style="font-weight: 500;font-size: 18px">Clôture hebdomadaire</div>
</div>

@if($date_debut && $date_fin)
<div style="font-weight: 500;font-size: 15px;margin-left: 5px">
    <span colspan="2" class="text-left" style="font-size: 15px">Du:  </span><label class="mt-20" style="font-size: 13px;margin-left: 110px !important;">{{$date_debut}}</label>
</div>
<div style="font-weight: 500;font-size: 15px;margin-left: 5px">
    <span colspan="2" class="text-left" style="font-size: 15px">Au:  </span><label class="mt-20" style="font-size: 13px;margin-left: 110px !important;">{{$date_fin}}</label>
</div>
@endif

@if($entite_selected && $entite_selected)
<div style="font-weight: 500;font-size: 15px;margin-left: 5px">
    <span colspan="2" class="text-left" style="font-size: 15px">Entite:  </span><label class="mt-20" style="font-size: 13px;margin-left: 90px !important;">{{$entite_selected['designation']}}</label>
</div>
@endif
@if($type_commande && $type_commande)
<div style="font-weight: 500;font-size: 15px;margin-left: 5px">
    <span colspan="2" class="text-left" style="font-size: 15px">Type de commande:  </span><label class="mt-20" style="font-size: 13px;margin-left: 5px !important;">{{$type_commande['designation']}}</label>
</div>
@endif

@if($tranche_horaire && $tranche_horaire)
<div style="font-weight: 500;font-size: 15px;margin-left: 5px">
    <span colspan="2" class="text-left" style="font-size: 15px">Tranche horaire:  </span><label class="mt-20" style="font-size: 13px;margin-left: 23px !important;">{{$tranche_horaire['designation']}} {{$tranche_horaire['heure_debut_fr']}}/{{$tranche_horaire['heure_fin_fr']}}</label>
</div>
@endif

<div>

    <table class="table">
        <tr class="tr">
            <th class="whitespace-no-wrap">Jours</th>
            <th class="whitespace-no-wrap">NB CV</th>
            <th class="whitespace-no-wrap">NB LIV</th>
            <th class="whitespace-no-wrap">NB EMP</th>
            <th class="whitespace-no-wrap">OFFERT</th>
            <th class="whitespace-no-wrap">VENTES</th>
            <th class="whitespace-no-wrap">ENC ESP</th>
            <th class="whitespace-no-wrap">ENC BANQUE</th>
            <th class="whitespace-no-wrap">CA TOTAL</th>
            <th class="whitespace-no-wrap">MANQUANT</th>
        </tr>


        @for ($i = 0; $i < count($jours); $i++)
        <tr class="tr">
            <td class="td">{{$jours[$i]['date_fr']}}</td>
            <td class="td">
                @for ($c = 0; $c < count($couverts); $c++)
                  @if($couverts[$c]['date'] == $jours[$i]['date'])
                            {{$couverts[$c]['total']}}
                  @endif
                @endfor
            </td>
            <td class="td">
                @for ($l = 0; $l < count($livraisons); $l++)
                @if($livraisons[$l]['date'] == $jours[$i]['date'])
                {{$livraisons[$l]['total']}}
                @endif
                @endfor
            </td>
            <td class="td">
                @for ($em = 0; $em < count($emportes); $em++)
                @if($couverts[$em]['date'] == $jours[$i]['date'])
                {{$couverts[$em]['total']}}
                @endif
                @endfor
            </td>
            <td class="td">
                @for ($of = 0; $of < count($offerts); $of++)
                @if($couverts[$of]['date'] == $jours[$i]['date'])
                {{$offerts[$of]['total']}}
                @endif
                @endfor
            </td>
            <td class="td">
                @for ($v = 0; $v < count($ventes); $v++)
                @if($ventes[$v]['date'] == $jours[$i]['date'])
                {{$ventes[$v]['total']}}
                @endif
                @endfor
            </td>
            <td class="td">

            </td>
            <td class="td">
            </td>
            <td class="td"></td>
            <td class="td">
                @for ($m = 0; $m < count($manquants); $m++)
                @if($manquants[$m]['date'] == $jours[$i]['date'])
                {{$manquants[$m]['total']}}
                @endif
                @endfor
            </td>
        @endfor
    </table>

    <div style="text-align:left;margin-left: 10px !important;line-height: 17px;margin-top: 28px!important;">
        <div style="font-weight: 500;font-size: 18px">Encaissements par mode de paiement</div>
    </div>

    @if($encaissements)
    <table class="table">
        <tr class="tr">
            <th class="whitespace-no-wrap">Jours</th>
                @for ($mpd = 0; $mpd < count($mode_paiements); $mpd++)
                  <th class="whitespace-no-wrap">
                      {{$mode_paiements[$mpd]['designation']}}
                  </th>
                @endfor
            <th class="whitespace-no-wrap">Total</th>
        </tr>


        @for ($enc = 0; $enc < count($encaissements); $enc++)
        <tr class="tr">
            <td class="td">{{$encaissements[$enc]['date_fr']}}</td>

            @for ($mpdjj = 0; $mpdjj < count($mode_paiements); $mpdjj++)
            <th class="whitespace-no-wrap">
                @for ($enc_mod = 0; $enc_mod < count($mode_paiement_encaissements); $enc_mod++)
                    @if($mode_paiement_encaissements[$enc_mod]['modepaiement'] == $mode_paiements[$mpdjj]['designation'] && $encaissements[$enc]['date'] == $mode_paiement_encaissements[$enc_mod]['date'])

                                              {{$mode_paiement_encaissements[$enc_mod]['total']}}
                    @endif
                @endfor
            </th>
            @endfor
            <td class="td">
            </td>
            @endfor
    </table>
    @endif

    <div style="text-align:left;margin-left 10px !important;line-height: 17px;margin-top: 28px!important;">
        <div style="font-weight: 500;font-size: 18px">Billetages</div>
    </div>

    @if($billetages)
    <table class="table">
        <tr class="tr">
            <th class="whitespace-no-wrap">N°</th>
            <th class="whitespace-no-wrap">Designation</th>
            <th class="whitespace-no-wrap">Nombre</th>
            <th class="whitespace-no-wrap">Total</th>

        </tr>


        @for ($b = 0; $b < count($billetages); $b++)
        <tr class="tr">
            <td class="td">{{$b+1}}</td>
            <td class="td">{{$billetages[$b]['typebillet']}}</td>
            <td class="td">{{$billetages[$b]['nombre']}}</td>
            <td class="td">{{$billetages[$b]['total']}}</td>
        </tr>
            @endfor
    </table>
    @endif
</div>


</body>
</html>
