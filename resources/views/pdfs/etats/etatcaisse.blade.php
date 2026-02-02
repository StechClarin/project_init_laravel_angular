@extends('pdfs.layouts.layout-export')

@section('title', "Etats suivi caisse")

@section('content')
    <div style="font-weight: 500;font-size: 18px;margin-bottom: 15px">SUIVI DE CAISSE JOURNALIER</div>
    <span style="font-weight: bold;text-decoration: underline">PERIODE:</span>
    <span style="margin-left: 15px">Du {{$date_debut}} - Au {{$date_fin}}</span>

    <div style="text-align:left;line-height: 22px;margin-bottom: 28px ; margin-top: 15px">
        @foreach($data as $key => $value)
        
            <div style="font-weight: 500;font-size: 18px;margin-bottom:20px;">
                <span style="font-weight: bold;text-decoration: underline">CAISSE:</span>
                <span style="margin-left: 17px">{{$value->caisse->nom}}</span>
            </div>

            <table class="table" >
                <tr class="tr">
                    <td class="td" colspan="2" style="border-top: 1px solid white !important;border-left: 1px solid white !important; font-size: 13px"></td>
                    <td class="td">ENTREES</td>
                    <td class="td" colspan="6" style="font-size: 13px">SORTIES</td>
                </tr>

                <tr class="tr">
                    <th class="whitespace-no-wrap">Periode</th>
                    <th class="whitespace-no-wrap">LIBELLES</th>
                    <th class="whitespace-no-wrap">ESPECES</th>
                    @foreach($value->pointventesalls as  $pos)
                        <th class="whitespace-no-wrap">{{$pos->nom}}</th>
                    @endforeach
                    <th class="whitespace-no-wrap">Solde</th>
                </tr>

                <tr class="tr">
                    <td class="td">{{\Carbon\Carbon::parse($value->date_veille)->format('d/m/Y') }}</td>
                    <td class="td">Solde veille</td>
                    <td class="td"> {{number_format($value->soldeGlobal, 0, ',', ' ')}}</td>
                    @foreach($value->pointventesalls as  $pos)
                        <td class="td"></td>
                    @endforeach
                    <td class="td" style="font-weight: bold">  
                    <?php $mont  = $value->soldeGlobal ?? 0;echo number_format($mont, 0, ',', ' ');?>
                    </td>
                </tr>
                
                <?php  $totalentree  = 0;?>
            {{-- POUR LES LIGNES DE CREDITS --}}
                @if(count($value->lignecredits) > 0)
                    <tr class="tr">
                        <td class="td" colspan="9" style="font-weight: bold">LIGNE CREDIT</td>
                    </tr>
                    @foreach($value->lignecredits as  $LC)
                    <tr class="tr">
                        <td class="td">{{ \Carbon\Carbon::parse($LC->date)->format('d/m/Y') }}</td>
                        <td class="td">{{$LC->code}}</td>
                        <td class="td">{{number_format($LC->montant, 0, ',', ' ')}}</td>
                        @foreach($value->pointventesalls as  $pos)
                            <td class="td"></td>
                        @endforeach
                        <td class="td" style="font-weight: bold; border-bottom: solid 1px !important;">
                            <?php $mont  = $mont + $LC->montant; $totalentree  = $totalentree + $LC->montant;echo number_format($mont, 0, ',', ' ');?>
                        </td>
                    </tr>
                    @endforeach
                @endif

                {{-- POUR LES PAIEMENTS COMMANDE --}}
                @if(count($value->paiementCommande) > 0)
                    <tr class="tr">
                        <td class="td" colspan="9" style="font-weight: bold">PAIEMENT COMMANDE </td>
                    </tr>
                    @foreach($value->paiementCommande as  $paiements)
                    <tr class="tr">
                        <td class="td">{{\Carbon\Carbon::parse($paiements->date)->format('d/m/Y')}}</td>
                        <td class="td">{{$paiements->code}}</td>
                        <td class="td">{{number_format($paiements->montant, 0, ',', ' ')}}</td>
                        @foreach($value->pointventesalls as  $pos)
                            <td class="td"></td>
                        @endforeach
                        <td class="td" style="font-weight: bold; border-bottom: solid 1px !important;">
                            <?php $mont  = $mont + $paiements->montant;$totalentree  = $totalentree + $paiements->montant; echo number_format($mont, 0, ',', ' ');?>
                        </td>
                    </tr>
                    @endforeach
                @endif


            {{-- POUR LES APPROS CASHS --}}
                @if(count($value->approsRecepteur) > 0)
                    <tr class="tr">
                        <td class="td" colspan="9" style="font-weight: bold">APPRO CASH RECEPTEUR</td>
                    </tr>
                    @foreach($value->approsRecepteur as  $approcashs)
                    <tr class="tr">
                        <td class="td">{{\Carbon\Carbon::parse($approcashs->date)->format('d/m/Y') }}</td>
                        <td class="td">{{$approcashs->motif}}</td>
                        <td class="td">{{number_format($approcashs->montant, 0, ',', ' ')}}</td>
                        @foreach($value->pointventesalls as  $pos)
                            <td class="td"></td>
                        @endforeach
                        <td class="td" style="font-weight: bold; border-bottom: solid 1px !important;">
                            <?php $mont  = $mont + $approcashs->montant; $totalentree  = $totalentree + $approcashs->montant;echo number_format($mont, 0, ',', ' ');?>
                        </td>
                    </tr>
                    @endforeach
                @endif

                <?php $totalsortie  = 0;?>

            {{-- POUR LES APPROS CASHS EMETTEURS --}}
                @if(count($value->approsEmmetteur) > 0)
                    <tr class="tr">
                        <td class="td" colspan="9" style="font-weight: bold">APPRO CASH EMETTEUR</td>
                    </tr>
                    @foreach($value->approsEmmetteur as  $approcashsemet)
                    <tr class="tr">
                        <td class="td">{{\Carbon\Carbon::parse($approcashsemet->date)->format('d/m/Y') }}</td>
                        <td class="td">{{$approcashsemet->motif}}</td>
                        <td class="td">{{number_format($approcashsemet->montant, 0, ',', ' ')}}</td>
                        @foreach($value->pointventesalls as  $pos)
                            <td class="td"></td>
                        @endforeach
                        <td class="td" style="font-weight: bold; border-bottom: solid 1px !important;">
                            <?php $mont  = $mont - $approcashsemet->montant; $totalsortie  = $totalsortie+$approcashsemet->montant; echo number_format($mont, 0, ',', ' ');?>
                        </td>
                    </tr>
                    @endforeach
                @endif

                {{-- POUR LES DEPENSES --}}
                @if(count($value->depenses) > 0)
                    <tr class="tr">
                        <td class="td" colspan="9" style="font-weight: bold">DEPENSES</td>
                    </tr>
                    @foreach($value->depenses as  $depense)
                    <tr class="tr">
                        <td class="td">{{\Carbon\Carbon::parse($depense->date)->format('d/m/Y') }}</td>
                        <td class="td">{{$depense->motif}}</td>
                        <td class="td"></td>
                        @foreach($value->pointventesalls as  $pos)
                            <td class="td">
                                @if($pos->id ==$depense->point_vente_id)
                                {{number_format($depense->valeur, 0, ',', ' ')}}
                                @endif
                            </td>
                        @endforeach
                        <td class="td" style="font-weight: bold; border-bottom: solid 1px !important;">
                            <?php $mont  = $mont - $depense->valeur; echo number_format($mont, 0, ',', ' ');?>
                        </td>
                    </tr>
                    @endforeach
                @endif

                {{-- LES TOTAUX--}}
                <?php  $totaldepense  = 0;?>
                <tr class="tr">
                    <td class="td">--</td>
                    <td class="td">--</td>
                    <td class="td" style="font-weight: bold">
                        TOTAUX
                    </td>
                    @foreach($value->pointventesalls as  $pos)
                        <td class="td">
                            {{number_format($pos->montant, 0, ',', ' ')}}
                            <?php  $totalsortie  = $totalsortie+$pos->montant; $totaldepense  = $totaldepense+$pos->montant;?>

                        </td>
                    @endforeach
                    <td class="td" style="font-weight: bold">
                        <?php echo number_format($totalsortie, 0, ',', ' ');?>
                    </td>
                </tr>
                <tr class="tr">

                    <td class="td" colspan="2" style="border-bottom: 1px solid white !important;border-left: 1px solid white !important; font-size: 13px"></td>
                    <td class="td" style="font-weight: bold">DEPENSES GLOBALES</td>
                    <td class="td" style="border: black 4px"><?php echo number_format($totaldepense, 0, ',', ' ');?></td>
                    <td class="td" colspan="5" style="border-bottom: 1px solid white !important;border-right: 1px solid white !important; font-size: 13px"></td>
                </tr>
                
                <tr class="tr">

                    <td class="td" colspan="2" style="border-bottom: 1px solid white !important;border-left: 1px solid white !important; font-size: 13px"></td>
                    <td class="td" style="font-weight: bold">SOLDE CAISSE TOTAL</td>
                    <td class="td" style="border: black 4px">
                        @if($mont)
                            <?php
                            echo number_format($mont, 0, ',', ' ');
                            ?>
                        @endif
        
                    </td>
                    <td class="td" colspan="5" style="border-bottom: 1px solid white !important;border-right: 1px solid white !important; font-size: 13px"></td>
        
                </tr>
            </table>
        @endforeach
    </div>
    

@endsection