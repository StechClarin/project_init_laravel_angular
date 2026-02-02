
<style>
    @page {
            margin: 20px 20px;
        }

    .table_css
    {
        font-size: 11px !important;
    }
</style>
@extends('pdfs.layouts.layout-dossier')

@php
    $typebls = [
        1 => "Original",
        2 => "Copie",
    ];
    $typeasres = [
        1 => "Original",
        2 => "Par STT en S.A.P S.A.U.F"
    ];
    $typedpis = [
        1 => "Pas de DPI",
        2 => "A venir",
        3 => "Original",
        4 => " Par STT"
    ];
    $typebscs = [
        1 => " Par STT" ,
        2 => "Original"
    ];
    $items_per_page = count($data[0]['marchandises'] ?? []);
    $chunks = $data[0]['marchandises'] ?? [];

    if (count($chunks) >= 1)
    {
        if (count($chunks) === $items_per_page)
        {
            $chunks = [$chunks];
        }
        else
        {
            $chunks = array_chunk($chunks, $items_per_page);
        }
    }

    //dd($chunks);
@endphp
@section('content')
    @for($k = 0; $k < count($chunks) ; $k++)
        <table style="width:100%">
            <tr>
                <td>
                    <img style="width: 200px" src="{{asset('assets/media/logos/logo.svg')}}" />
                </td>
            </tr>
        </table>

        <div class="text-uppercase fw-bold mt-10 text-center" style="font-size: 20px;font-family: sans-serif;">
            <span>DOSSIER {{$data[0]['type_dossier']['nom']}}</span>
        </div>

        <table style="width:100%" class="mt-10">
            <tr>
                <td>
                    <div class="item-border">{{$data[0]['date_fr']}}</div>
                </td>
                <td style="width: 60%">
                    <div class="item-border">{{$data[0]['client']['display_text']}}</div>
                </td>
                <td>
                    <div class="item-border">22CAC0002</div>
                </td>
            </tr>
        </table>

        <table style="width:100%" class="mt-10">
            <tr>
                <td style="width: 100px">
                    <div style="font-size: 15px;font-family: sans-serif;padding: 5px 0px; text-align: left;">Nom du navire</div>
                </td>
                <td>
                    <div class="item-border">{{$data[0]['navire']}} &nbsp;</div>
                </td>
                <td  style="width: 100px">
                    <div style="font-size: 15px;font-family: sans-serif;padding: 5px 0px; text-align: center;">Date de départ</div>
                </td>
                <td style="width: 100px">
                    <div class="item-border">{{$data[0]['date_depart_fr']}} &nbsp;</div>
                </td>
                <td  style="width: 150px">
                    <div style="font-size: 15px;font-family: sans-serif;padding: 5px 0px; text-align: center;">Date prévue d'arrivée</div>
                </td>
                <td style="width: 100px">
                    <div class="item-border">{{$data[0]['date_arrivee_fr']}} &nbsp;</div>
                </td>
            </tr>
        </table>
        
        <table class="mt-10">
            <tr>
                <td style="width: 25%">
                    <div style="font-size: 15px;font-family: sans-serif;padding: 5px 0px; text-align: left;">Nomenclature douanière</div>
                </td>
                <td style="width: 100px">
                    <div class="item-border">{{$data[0]['nomenclature_asuivre_fr']}} &nbsp;</div>
                </td>
            </tr>
        </table>

        <table style="width:100%" class="mt-10 table_css">
            <tr>
                <th class="" style="background-color: {{$data[0]['type_dossier']['couleurbg']}}">
                    <div style="font-size: 13px;font-family: sans-serif;text-align: center;text-transform: uppercase;color: {{$data[0]['type_dossier']['couleurfg']}}">{{$data[0]['type_marchandise']['nom']}} &nbsp;</div>
                </th>
            </tr>
            <tr>
                <td>
                    <div style="padding: 10px;text-align: left !important;margin-left: 10px">
                        @if(isset($data[0]['type_importation']) && strtolower($data[0]['type_importation']['description']) == 'tc')
                            <div class="mt-10" style="font-size: 15px;">Mode d'expédition :@if(isset($data[0]['conteneurs']) && count($data[0]['conteneurs']) > 0) {{count($data[0]['conteneurs'])}} @endif  {{$data[0]['type_importation']['description']}}</div>

                            @if(isset($data[0]['conteneurs']) && count($data[0]['conteneurs']) > 0)
                                <span style="">
                                    Détails TC :
                                    @foreach($data[0]['conteneurs'] as $index => $conteneur)
                                        <span>{{$conteneur['numero']. ' - ' . $conteneur['type_conteneur']['nom']}} </span>
                                        @if($index < count($data[0]['conteneurs']) - 1)
                                         <span>|</span>
                                        @endif
                                    @endforeach
                                </span>
                            @endif
                        @endif
                        <table class="mt-10 table_css">
                            <tr>
                                @if($data[0]['type_marchandise_id'] == 1)
                                    <td>QUANTITÉ</td>
                                    <td>DÉSIGNATION</td>
                                    <td>POIDS<span style="font-size: 10px">(KG)</span></td>
                                @elseif($data[0]['type_marchandise_id'] == 2)
                                    <td>CODE</td>
                                    <td>MARQUE</td>
                                    <td>MODELE</td>
                                    <td>CYLINDRE</td>
                                    <td>ENERGIE</td>
                                    <td>POIDS<span style="font-size: 10px">(KG)</td>
                                    <td>Nº CHASSIS</td>
                                @endif
                            </tr>

                            @for($i = 0; $i < count($chunks[$k]); $i++)
                                <tr>
                                    @if($data[0]['type_marchandise_id'] == 1)
                                        <td>{{$chunks[$k][$i]['quantite']}} &nbsp;</td>
                                        <td>{{$chunks[$k][$i]['nom'] ?? ""}}  &nbsp;</td>
                                        <td>{{$chunks[$k][$i]['poids']}} &nbsp;</td>
                                    @elseif($data[0]['type_marchandise_id'] == 2)
                                        <td>{{$chunks[$k][$i]['marchandise']['code_vehicule'] ?? ''}} &nbsp;</td>
                                        <td>{{$chunks[$k][$i]['marchandise']['marque']['nom'] ?? ''}} &nbsp;</td>
                                        <td>{{$chunks[$k][$i]['marchandise']['modele']['nom'] ?? ''}} &nbsp;</td>
                                        <td>{{$chunks[$k][$i]['marchandise']['cylindre'] ?? ''}} &nbsp;</td>
                                        <td>{{$chunks[$k][$i]['marchandise']['energie']['nom'] ?? ''}} &nbsp;</td>
                                        <td>{{$chunks[$k][$i]['poids'] ?? ''}} &nbsp;</td>
                                        <td>{{$chunks[$k][$i]['numero_chassis'] ?? ''}} &nbsp;</td>
                                    @endif
                                    
                                </tr>
                            @endfor
                            
                        </table>
                    </div>
                </td>
            </tr>
        </table>

        @if(count($chunks[$k]) >= 9)
            <div style="page-break-before: always;"></div>

            <table style="width:100%">
                <tr>
                    <td>
                        <img style="width: 200px" src="{{asset('assets/media/logos/logo.svg')}}" />
                    </td>
                </tr>
            </table>
    
            <div class="text-uppercase fw-bold mt-10 text-center" style="font-size: 20px;font-family: sans-serif;">
                <span>DOSSIER {{$data[0]['type_dossier']['nom']}}</span>
            </div>

            <table style="width:100%" class="mt-10">
                <tr>
                    <td>
                        <div class="item-border">{{$data[0]['date_fr']}}</div>
                    </td>
                    <td style="width: 60%">
                        <div class="item-border">{{$data[0]['client']['display_text']}}</div>
                    </td>
                    <td>
                        <div class="item-border">22CAC0002</div>
                    </td>
                </tr>
            </table>

        @endif

        

       

        <table style="width:100%" class="mt-16 table_css">
            <tr>
                <th class="" style="background-color: {{$data[0]['type_dossier']['couleurbg']}}">
                    <div style="font-size: 13px;font-family: sans-serif;text-align: center;text-transform: uppercase;color: {{$data[0]['type_dossier']['couleurfg']}}">DOCUMENTS JOINTS OBLIGATOIRES</div>
                </th>
            </tr>
            <tr>
                <td>
                    <div style="padding: 10px">
                        <table style="width: 100%;border-collapse: none!important">
                            <tr>
                                <td style="width: 50%;border: none;text-align: left">
                                    @if(isset($data[0]['bls']))
                                        <div style="font-size: 10px;text-align: left !important;border-bottom: 1px solid black;padding-bottom: 7px;margin-bottom: 15px;flex-wrap: nowrap">CONNAISSEMENT N°:
                                            @foreach($data[0]['bls'] as $index => $bl)
                                                 {{$bl['numero']}} {{$typebls[(int)$bl['type_id']]}}
                                                @if($index < count($data[0]['bls']) - 1)
                                                    <span>|</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                    @if(isset($data[0]['ffs']))
                                        <div style="font-size: 10px;text-align: left !important;border-bottom: 1px solid black;padding-bottom: 7px;margin-bottom: 15px;flex-wrap: nowrap">FACTURE FOURNISSEUR:
                                            @foreach($data[0]['ffs'] as $index => $ff)
                                                 {{$ff['montant'] . ' ' . $ff['devise']['nom']}}
                                                @if($index < count($data[0]['ffs']) - 1)
                                                    <span>|</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                    @if(isset($data[0]['ffts']))
                                        <div style="font-size: 10px;text-align: left !important;border-bottom: 1px solid black;padding-bottom: 7px;margin-bottom: 15px;flex-wrap: nowrap">FACTURE FRÊT:
                                            @foreach($data[0]['ffts'] as $index => $fft)
                                                 {{$fft['montant'] . ' ' . $fft['devise']['nom']}}
                                                @if($index < count($data[0]['ffts']) - 1)
                                                    <span>|</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td style="width: 5%;border: none;text-align: left"></td>
                                <td style="width: 45%;border: none;text-align: left">
                                    @php
                                        //dd($data[0]);
                                    @endphp
                                    @if(isset($data[0]['asres']))
                                        <div style="font-size: 10px;text-align: left !important;border-bottom: 1px solid black;padding-bottom: 7px;margin-bottom: 15px;flex-wrap: nowrap">ASSURANCE 
                                            @foreach($data[0]['asres'] as $index => $asre)
                                                {{$typeasres[(int)$asre['type_id']]}}
                                                @if($index < count($data[0]['asres']) - 1)
                                                    <span>|</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                    @if(isset($data[0]['dpis']))
                                        <div style="font-size: 10px;text-align: left !important;border-bottom: 1px solid black;padding-bottom: 7px;margin-bottom: 15px;flex-wrap: nowrap">D.P.I 
                                            @foreach($data[0]['dpis'] as $index => $dpi)
                                                {{$typedpis[(int)$dpi['type_id']]}}
                                                @if($index < count($data[0]['dpis']) - 1)
                                                    <span>|</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                    <div style="font-size: 12px;text-align: left !important;border-bottom: 1px solid black;padding-bottom: 7px;margin-bottom: 15px">A.V</div>
                                    @if(isset($data[0]['bscs']))
                                        <div style="font-size: 10px;text-align: left !important;border-bottom: 1px solid black;padding-bottom: 7px;margin-bottom: 15px;flex-wrap: nowrap">BSC
                                            @foreach($data[0]['bscs'] as $index => $bsc)
                                                {{$typebscs[(int)$bsc['type_id']]}}
                                                @if($index < count($data[0]['bscs']) - 1)
                                                    <span>|</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </td>

                            </tr>
                        </table>
                        
                    </div>
                </td>
            </tr>
        </table>


        @if(isset($data[0]['documents']) && count($data[0]['documents']) > 0)
            <table style="width:100%" class="mt-16 table_css">
                <tr>
                    <th class="" style="background-color: {{$data[0]['type_dossier']['couleurbg']}}">
                        <div style="font-size: 13px;font-family: sans-serif;text-align: center;text-transform: uppercase;color: {{$data[0]['type_dossier']['couleurfg']}}">DOCUMENTS FACULTATIFS</div>
                    </th>
                </tr>
                <tr>
                    <td>
                        <div style="padding: 10px">
                            <table style="width: 100%;border-collapse: none!important">
                                <tr>
                                    <td style="width: 100%;border: none;text-align: left">
                                        <div style="font-size: 12px;text-align: left;padding-bottom: 7px;margin-bottom: 15px;text-transform: uppercase">CERTIFICAT D'origine | certificat eur | note de colisage</div>
                                    </td>
                                    <td style="width: 10%;border: none;text-align: left"></td>
                                    <td style="width: 40%;border: none;text-align: left"></td>
                                    <td style="width: 10%;border: none;text-align: left"></td>
                                </tr>
                            </table>
                            
                        </div>
                    </td>
                </tr>
            </table>
        @endif

        <table style="width:100%" class="mt-16">
            <tr>
                <td style="width: 34%;vertical-align: top">
                    <div style="font-size: 13px;font-family: sans-serif;text-align: left;text-transform: uppercase;">REÇU LE :</div>
                </td>
                <td style="width: 33%">
                    <div style="font-size: 13px;font-family: sans-serif;text-align: center;text-transform: uppercase;border: 1px solid black;height: 100px;padding: 10px">DÉCHARGE STT</div>
                </td>
                <td style="width: 33%">
                    <div style="font-size: 13px;font-family: sans-serif;text-align: center;text-transform: uppercase;border: 1px solid black;height: 100px;padding: 10px">SIGNATURE ET CACHET CLIENT</div>
                </td>
            </tr>
            
        </table>
{{-- 
        @if(($k + 1) < count($chunks))
            <div style="page-break-before: always;"></div>
        @endif --}}
    @endfor

@endsection
