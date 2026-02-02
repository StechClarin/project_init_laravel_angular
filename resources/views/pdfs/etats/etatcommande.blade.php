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
            margin-top: 2.1cm;
            margin-left: 1.0cm;
            margin-right: 1.0cm;
            margin-bottom: 2.0cm;
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

        .table-footer{
            font-weight: bold; border-bottom: solid black 2px !important;border-top: solid black 2px !important;
        }
        .table-footer-vente{
            font-weight: bold; border-bottom: solid #EAECEE 2px !important; border-top: solid #EAECEE 2px !important;background-color: #EAECEE !important;
        }
        .table-footer-conso{
            font-weight: bold; border-bottom: solid #D5D8DC 2px !important; border-top: solid #D5D8DC 2px !important;background-color: #D5D8DC !important;
        }
        .table-footer-perte{
            font-weight: bold; border-bottom: solid #808B96 2px !important; border-top: solid #808B96 2px !important;background-color: #808B96 !important;
        }
        .table-footer-offert{
            font-weight: bold; border-bottom: solid #ABB2B9 2px !important; border-top: solid #ABB2B9 2px !important;background-color: #ABB2B9 !important;
        }

    </style>
    @if(!$is_excel)
        <title>PDF Etat des ventes par periode</title>
    @endif
</head>
<body>

@if($date_debut && $date_fin)
<div style="font-weight: 500;font-size: 15px;margin-left: 5px">
    <span colspan="2" class="text-left" style="font-size: 15px">Du:  </span><label class="mt-20" style="font-size: 13px;margin-left: 110px !important;">{{$date_debut}}</label>
</div>
<div style="font-weight: 500;font-size: 15px;margin-left: 5px">
    <span colspan="2" class="text-left" style="font-size: 15px">Au:  </span><label class="mt-20" style="font-size: 13px;margin-left: 110px !important;">{{$date_fin}}</label>
</div>
@endif

@if($point_vente && $point_vente)
<div style="font-weight: 500;font-size: 15px;margin-left: 5px">
    <span colspan="2" class="text-left" style="font-size: 15px">Point vente:  </span><label class="mt-20" style="font-size: 13px;margin-left: 60px !important;">{{$point_vente->nom}}</label>
</div>
@endif

<div>

    @if($data)
        @for ($i = 0; $i < count($data); $i++)

            <div style="text-align:center;line-height: 22px;margin-bottom: 28px">
                <div style="font-weight: 500;font-size: 18px">Tranche horaire: <span style="font-weight: normal">{{$data[$i]['tranche_horaire']->nom}}</span></div>
            </div>


    <table class="table">


        <tr class="tr">
            <th class="whitespace-no-wrap">Type</th>
            <th class="whitespace-no-wrap">Produit</th>
            <th class="whitespace-no-wrap">Quantité</th>
            <th class="whitespace-no-wrap">Montant</th>
            <th class="whitespace-no-wrap">#</th>
        </tr>

        @if($data[$i]['details'])
            @for ($j = 0; $j < count($data[$i]['details']); $j++)
                <tr class="tr">
                    <td class="td" colspan="5" style="font-weight: bold">{{$data[$i]['details'][$j]['famille']->designation}}</td>
                </tr>
                @if($data[$i]['details'][$j]['produits_vente'] && count($data[$i]['details'][$j]['produits_vente']) > 0)
                    @for ($k = 0; $k < count($data[$i]['details'][$j]['produits_vente']); $k++)
                    <tr class="tr">
                        <td class="td table-footer-vente">Vente</td>
                        <td class="td table-footer-vente">{{$data[$i]['details'][$j]['produits_vente'][$k]['designation']}}</td>
                        <td class="td table-footer-vente">{{$data[$i]['details'][$j]['produits_vente'][$k]['quantite']}}</td>
                        <td class="td table-footer-vente"><?php $mont  = $data[$i]['details'][$j]['produits_vente'][$k]['montant'];  echo number_format($mont, 0, ',', ' ');?></td>
                        <td class="td table-footer-vente">#</td>
                    </tr>
                    @endfor
                @endif


                @if($data[$i]['details'][$j]['produits_conso'] && count($data[$i]['details'][$j]['produits_conso']) > 0)
                    @for ($k = 0; $k < count($data[$i]['details'][$j]['produits_conso']); $k++)
                    <tr class="tr">
                        <td class="td table-footer-conso">Conso</td>
                        <td class="td table-footer-conso">{{$data[$i]['details'][$j]['produits_conso'][$k]['designation']}}</td>
                        <td class="td table-footer-conso">{{$data[$i]['details'][$j]['produits_conso'][$k]['quantite']}}</td>
                        <td class="td table-footer-conso"><?php $mont  = $data[$i]['details'][$j]['produits_conso'][$k]['montant'];  echo number_format($mont, 0, ',', ' ');?></td>
                        <td class="td table-footer-conso">#</td>
                    </tr>
                    @endfor
                @endif

                @if($data[$i]['details'][$j]['produits_offert'] && count($data[$i]['details'][$j]['produits_offert']) > 0)
                    @for ($k = 0; $k < count($data[$i]['details'][$j]['produits_offert']); $k++)
                    <tr class="tr">
                        <td class="td table-footer-offert">Offert</td>
                        <td class="td table-footer-offert">{{$data[$i]['details'][$j]['produits_offert'][$k]['designation']}}</td>
                        <td class="td table-footer-offert">{{$data[$i]['details'][$j]['produits_offert'][$k]['quantite']}}</td>
                        <td class="td table-footer-offert"><?php $mont  = $data[$i]['details'][$j]['produits_offert'][$k]['montant'];  echo number_format($mont, 0, ',', ' ');?></td>
                        <td class="td table-footer-offert">#</td>
                    </tr>
                    @endfor
                @endif

                @if($data[$i]['details'][$j]['produits_perte'] && count($data[$i]['details'][$j]['produits_perte']) > 0)
                    @for ($k = 0; $k < count($data[$i]['details'][$j]['produits_perte']); $k++)
                    <tr class="tr">
                        <td class="td table-footer-perte">Perte</td>
                        <td class="td table-footer-perte">{{$data[$i]['details'][$j]['produits_perte'][$k]['designation']}}</td>
                        <td class="td table-footer-perte">{{$data[$i]['details'][$j]['produits_perte'][$k]['quantite']}}</td>
                        <td class="td table-footer-perte"><?php $mont  = $data[$i]['details'][$j]['produits_perte'][$k]['montant'];  echo number_format($mont, 0, ',', ' ');?></td>
                        <td class="td table-footer-perte">#</td>
                    </tr>
                    @endfor
                @endif


            <tr class="tr table-footer">
                <td class="td table-footer"  style="font-weight: bold">CA</td>
                <td class="td table-footer"  style="font-weight: bold">VENTE</td>
                <td class="td table-footer"  style="font-weight: bold">CONSO INTERNE</td>
                <td class="td table-footer"  style="font-weight: bold">OFFERT</td>
                <td class="td table-footer"  style="font-weight: bold">PERTE</td>
            </tr>
            <tr class="tr table-footer">
                <td class="td table-footer"  style="font-weight: bold">#</td>
                <td class="td"  style="font-weight: bold">
                    <?php $mont  = $data[$i]['details'][$j]['montant_vente_famille'];  echo number_format($mont, 0, ',', ' ');?>
                </td>
                <td class="td"  style="font-weight: bold">
                    <?php $mont  = $data[$i]['details'][$j]['montant_conso_famille'];  echo number_format($mont, 0, ',', ' ');?></td>
                <td class="td"  style="font-weight: bold">
                    <?php $mont  = $data[$i]['details'][$j]['montant_offert_famille'];  echo number_format($mont, 0, ',', ' ');?></td>
                <td class="td"  style="font-weight: bold">
                    <?php $mont  = $data[$i]['details'][$j]['montant_perte_famille'];  echo number_format($mont, 0, ',', ' ');?></td>
            </tr>

            @endfor
        @endif

    </table>

    <table class="table">

        <tr class="tr">
            <th class="whitespace-no-wrap">CA</th>
            <th class="whitespace-no-wrap">CONSO</th>
            <th class="whitespace-no-wrap">OFFERT</th>
            <th class="whitespace-no-wrap">PERTE</th>
        </tr>

        <tr class="tr">
            <td class="td"><?php $mont  = $data[$i]['ca'];  echo number_format($mont, 0, ',', ' ');?> FCFA</td>
            <td class="td"><?php $mont  = $data[$i]['conso'];  echo number_format($mont, 0, ',', ' ');?> FCFA</td>
            <td class="td"><?php $mont  = $data[$i]['offert'];  echo number_format($mont, 0, ',', ' ');?> FCFA</td>
            <td class="td"><?php $mont  = $data[$i]['perte'];  echo number_format($mont, 0, ',', ' ');?></td>
        </tr>

    </table>

    @endfor
    @endif

</div>


</body>


</html>
