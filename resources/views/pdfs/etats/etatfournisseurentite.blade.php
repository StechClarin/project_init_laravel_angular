
@extends('pdfs.layouts.layout-export')

@section('title', "FOURNISSEUR PAR ENTITE ")

@section('content')
    <div style="text-align:left;line-height: 22px;margin-bottom: 28px margin-top: 20px !important;">
        <div style="font-weight: 500;font-size: 18px">RECAPITULATIF FOURNISSEUR PAR ENTITE</div>
        <div style="font-size: 15px;">Du {{$date_debut}} - Au {{$date_fin}}</div>

    </div>



    <div style="margin-top: 7px;">

        <table class="table">
            <tr class="tr">
                <th class="whitespace-no-wrap text-center">N°</th>
                <th class="whitespace-no-wrap text-center">Nom Complet</th>
                @foreach($point_ventealls as $key => $oneentite)
                    <th class="whitespace-no-wrap text-center">{{$oneentite->nom}}</th>
                @endforeach
                <th class="whitespace-no-wrap text-center">Total dépense</th>
            </tr>
            <?php  $total  = 0;?>
            @foreach($data as $key => $value)
            <?php  $totaldepense  = 0;?>

                <tr class="tr">
                    <td class="td">{{$key+1}}</td>
                    <td class="td">{{$value->tier->nom_complet}}</td>
                    @foreach($value->pointventes as $key => $onesf)
                        <td class="td">{{$onesf->montant}}</td>
                        <?php  $totaldepense  = $totaldepense+$onesf->montant;$total  = $total+$onesf->montant;?>
                    @endforeach
                    <td class="td"> <?php echo number_format($totaldepense, 0, ',', ' ');?></td>
                </tr>
            @endforeach
        </table>
        <div style="margin-left5px;font-size: 13px;font-weight: bold;text-align: right;margin-right:20px;margin: 30px 0 10px;text-transform: uppercase" >
            <div style="font-weight: 500;font-size: 13px">TOTAL: <?php echo number_format($total, 0, ',', ' ');?> FCFA</div>
        </div>

    </div>

@endsection
