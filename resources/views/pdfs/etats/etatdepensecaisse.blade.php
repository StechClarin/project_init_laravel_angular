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

    @if(!$is_excel)
        <title>PDF Etat des dépense par période</title>
    @endif
</head>
<body>


<div style="text-align:center;line-height: 22px;margin-bottom: 28px">
    <div style="font-weight: 500;font-size: 18px">Liste des dépenses</div>

</div>



<div>

    @if($data)
        @for ($i = 0; $i < count($data); $i++)

            <div style="text-align:center;line-height: 22px;margin-bottom: 28px">
                <div style="font-weight: 500;font-size: 18px">Tranche horaire: <span style="font-weight: normal">{{$data[$i]['tranche_horaire']->nom}}</span></div>
            </div>


    @if($data[$i]['details'])
            <table class="table">
            <tr>
                <th class="whitespace-no-wrap">N°</th>
                <th class="whitespace-no-wrap">Date</th>
                <th class="whitespace-no-wrap text-center">Point Vente</th>
                <th class="whitespace-no-wrap text-center">Caisse</th>
                <th class="whitespace-no-wrap text-center">Mode de paiement</th>
                <th class="whitespace-no-wrap text-center">Montant</th>
                <th class="whitespace-no-wrap text-center">Motif</th>
            </tr>
                @for ($j = 0; $j < count($data[$i]['details']); $j++)
                    <tr class="tr">
                        <td class="td">{{ $j+1}}</td>
                        <td class="td">{{ $data[$i]['details'][$j]["date"]}}</td>
                        <td class="td">
                            @if($data[$i]['details'][$j]['depense']["point_vente"])
                            {{ $data[$i]['details'][$j]['depense']["point_vente"]['nom']}}
                            @endif
                        </td>
                        <td class="td">
                            @if($data[$i]['details'][$j]['depense']["caisse"])
                            {{ $data[$i]['details'][$j]['depense']["caisse"]['nom']}}
                            @endif
                        </td>
                        <td class="td">
                            @if($data[$i]['details'][$j]["mode_paiement"])
                            {{ $data[$i]['details'][$j]["mode_paiement"]['nom']}}
                            @endif
                        </td>
                        <td class="td">{{ $data[$i]['details'][$j]["montant"]}}</td>
                        <td class="td">{{ $data[$i]['details'][$j]['depense']["motif"]}}</td>

                    </tr>
                @endfor
        </table>

        <div style="margin-left5px;font-size: 13px;font-weight: bold;text-align: right;margin-right:20px;margin: 30px 0 10px;text-transform: uppercase" >
            <div style="font-weight: 500;font-size: 13px">TOTAL: <?php $mont  = $data[$i]['total'];  echo number_format($mont, 0, ',', ' ');?> FCFA</div>
        </div>
        @endif
    @endfor
    @endif

</div>


</body>
</html>
