<html xmlns="http://www.w3.org/1999/html">
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
            margin-bottom: 0.3cm;
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
            height:0.5cm;
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

    <title>PDF COMPTABILTE DES DEPENSES PAR ENTITE </title>
</head>
<body>


<div style="margin-top: 7px">

    @if($data && count($data) > 0)
    @for ($i = 0; $i < count($data); $i++)
    <div style="text-align:left;line-height: 22px;margin-bottom: 10px">
        <div  style="">

        </div>
        <div style="font-size: 18px;text-decoration: underline;" class="font-bold"><span>Entite : </span><span>{{$data[$i]['entite']}}</span></div>
    </div>
    @if($data[$i]['fournisseurs'] && count($data[$i]['fournisseurs']) > 0)
    @for ($j = 0; $j < count($data[$i]['fournisseurs']); $j++)
    <div style="text-align:left;line-height: 22px;margin-bottom: 10px">
        <div style="font-size: 15px;"><span>Fournisseur : </span><span>{{$data[$i]['fournisseurs'][$j]['tier']}}</span></div>

        <div style="margin-top: 7px">

            <table class="table">
                <tr class="tr">
                    <th class="whitespace-no-wrap text-center">{{ __('customlang.nom') }}</th>
                    <th class="whitespace-no-wrap text-center">No de compte</th>
                    <th class="whitespace-no-wrap text-center">Date</th>
                    <th class="whitespace-no-wrap text-center">Net TTC</th>
                    <th class="whitespace-no-wrap text-center">Net HT</th>
                    <th class="whitespace-no-wrap text-center">Tva</th>
                    <th class="whitespace-no-wrap text-center">B.R.S</th>
                </tr>
                @if($data[$i]['fournisseurs'][$j]['poste_depenses'] && count($data[$i]['fournisseurs'][$j]['poste_depenses']) > 0)
                @for ($k = 0; $k < count($data[$i]['fournisseurs'][$j]['poste_depenses']); $k++)
                <tr class="tr">
                    <td class="td">{{$data[$i]['fournisseurs'][$j]['poste_depenses'][$k]->poste_depense_text}}</td>
                    <td class="td">{{$data[$i]['fournisseurs'][$j]['poste_depenses'][$k]->num_piece}}</td>
                    <td class="td">{{$data[$i]['fournisseurs'][$j]['poste_depenses'][$k]->date_piece}}</td>
                    <td class="td"><?php $mont  = $data[$i]['fournisseurs'][$j]['poste_depenses'][$k]->montant_ttc;  echo number_format($mont, 0, ',', ' ');?></td>
                    <td class="td"><?php $mont  = $data[$i]['fournisseurs'][$j]['poste_depenses'][$k]->montant_ht;  echo number_format($mont, 0, ',', ' ');?></td>
                    <td class="td">
                        @if($data[$i]['fournisseurs'][$j]['poste_depenses'][$k]->taxe == 'tva')
                        <label class="container" style="margin-left: 20px !important;">
                            <input type="checkbox" checked="checked">
                            <span class="checkmark"></span>
                        </label>
                        @endif
                    </td>
                    <td class="td">
                        @if($data[$i]['fournisseurs'][$j]['poste_depenses'][$k]->taxe == 'brs')
                        <label class="container" style="margin-left: 20px !important;">
                            <input type="checkbox" checked="checked">
                            <span class="checkmark"></span>
                        </label>

                        @endif
                    </td>
                </tr>
                @endfor
                @endif

                <tr class="tr">
                    <td class="td" colspan="3" ></td>
                    <td class="td" style="border: black 2px"><?php $mont  = $data[$i]['fournisseurs'][$j]['total_ttc'];  echo number_format($mont, 0, ',', ' ');?></td>
                    <td class="td" style="border: black 2px"><?php $mont  = $data[$i]['fournisseurs'][$j]['total_ht'];  echo number_format($mont, 0, ',', ' ');?></td>
                    <td class="td" colspan="2"></td>
                </tr>
            </table>

        </div>
        @endfor
        @endif

        @endfor
        <div style="margin-left5px;font-size: 13px;font-weight: bold;text-align: right;margin-right:20px;margin: 30px 0 10px;text-transform: uppercase" >
            <div style="font-weight: 500;font-size: 13px">TOTAL NET TTC: <?php $mont  = 0;  echo number_format($mont, 0, ',', ' ');?> FCFA</div>
        </div>
        <div style="margin-left5px;font-size: 13px;font-weight: bold;text-align: right;margin-right:20px;margin: 30px 0 10px;text-transform: uppercase" >
            <div style="font-weight: 500;font-size: 13px">TOTAL PAYE: <?php $mont  = 0;  echo number_format($mont, 0, ',', ' ');?> FCFA</div>
        </div>
        @endif


    </div>
</div>


</body>
</html>
