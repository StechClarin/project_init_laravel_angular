
@extends('pdfs.layouts.layout-export')

@section('title', "RECAPITULATIF CATEGORIE DEPENSE")

@section('content')
    <div style="text-align:left;line-height: 22px;margin-bottom: 28px margin-top: 20px !important;">
        <div style="font-weight: 500;font-size: 18px">RECAPITULATIF CATEGORIE DEPENSE</div>
        <div style="font-size: 15px;">Du {{$date_debut}} - Au {{$date_fin}}</div>

    </div>

    <div style="text-align:left;line-height: 22px;margin-bottom: 28px margin-top: 20px !important;">
        <div style="font-weight: 500;font-size: 13px">RECAPITULATIF PAR ENTITE</div>
    </div>

    <div style="margin-top: 7px;">

        <table class="table">
            <tr class="tr">
                <th class="whitespace-no-wrap text-center">N°</th>
                <th class="whitespace-no-wrap text-center">Categorie de depense</th>
                @foreach($pointventesalls as $key => $pos)
                    <th class="whitespace-no-wrap text-center">{{$pos->nom}}</th>
                @endforeach
                <th class="whitespace-no-wrap text-center">Total dépense</th>
            </tr>
    
            @foreach($data as $key => $value)
                <?php  $totaldepense  = 0;?>
                <tr class="tr">
                    <td class="td">{{$key+1}}</td>
                    <td class="td">{{$value->categorie_depense->nom}}</td>
                    @foreach($value->pointventes as $key => $Onepos)
                        <td class="td">{{$Onepos->montant}}</td>
                        <?php  $totaldepense  = $totaldepense+$Onepos->montant;?>
                    @endforeach
                    <td class="td"> <?php echo number_format($totaldepense, 0, ',', ' ');?></td>
                </tr>
            @endforeach
        </table>
    
    </div>
    <div style="text-align:left;line-height: 22px;margin-bottom: 28px;margin-top: 20px !important;">
        <div style="font-weight: 500;font-size: 13px">RECAPITULATIF PAR SOCIETE FACTURATION</div>
    </div>
    
    <div style="margin-top: 7px;">

        <table class="table">
            <tr class="tr">
                <th class="whitespace-no-wrap text-center">N°</th>
                <th class="whitespace-no-wrap text-center">Denomination sociale</th>
                @foreach($societefacturationsalls as $key => $pos)
                    <th class="whitespace-no-wrap text-center">{{$pos->denomination_social}}</th>
                @endforeach
                <th class="whitespace-no-wrap text-center">Total dépense</th>
            </tr>
    
            <?php  $globale  = 0;?>

            @foreach($data as $key => $value)
                <?php  $totaldepense  = 0;?>
                <tr class="tr">
                    <td class="td">{{$key+1}}</td>
                    <td class="td">{{$value->categorie_depense->nom}}</td>
                    @foreach($value->societefacturations as $key => $Onesf)
                        <td class="td">{{$Onesf->montant}}</td>
                        <?php  $totaldepense  = $totaldepense+$Onesf->montant;?>
                    @endforeach
                    <td class="td"> <?php  $globale  = $globale+$totaldepense;echo number_format($totaldepense, 0, ',', ' ');?></td>
                </tr>
            @endforeach
        </table>
        <div style="margin-left5px;font-size: 13px;font-weight: bold;text-align: right;margin-right:20px;margin: 30px 0 10px;text-transform: uppercase" >
            <div style="font-weight: 500;font-size: 13px">TOTAL: <?php echo number_format($globale, 0, ',', ' ');?> FCFA</div>
        </div>
    </div>
@endsection
