@php
    $items_per_page = 3;
    $count_art = 1;
    $chunks = array_chunk($data, $items_per_page);
    $start_count = 1;
    $maxArt = $items_per_page * count($chunks);
    $regime_nd = null; $devise_ass_nd_id = null; $devise_fret_nd_id = null;

    if (count($data) > 0 && isset($data[0]['dossier']))
    {
        $regime_nd = $data[0]['dossier']['regime_nd'];
        $numero_connaissement = $data[0]['dossier']['numero_connaissement'];
        $navire_nd = $data[0]['dossier']['navire_nd'];
        $devise_ass_nd_id = $data[0]['dossier']['devise_ass_nd_id'];
        $devise_fret_nd_id = $data[0]['dossier']['devise_fret_nd_id'];
    }
    //dd($data);
@endphp

@extends('pdfs.layouts.layout-dossier')

@section('title', "Note de détail")

@section('content')

    @for($i = 0; $i <count($chunks) ; $i++)

        <table style="width:100%">
            <tr>
                <td>
                    <img style="width: 200px" src="{{asset('assets/media/logos/logo.svg')}}" />
                </td>

                <td>
                    <div class="text-uppercase fw-bold mt-16" style="font-size: 25px; float: right;font-family: sans-serif;">
                        <span>Note de detail</span>
                            <br>
                            <span style="font-size: 15px;margin-left:80px; font-weight: normal">({{count($data)}})</span>
                     
                    </div>
                </td>
            </tr>
        </table>
    
        <div class="mt-16">
            <table class="table_css" style="border: none">
                <tr style="border: none">
                    <th style="width:150px; border: none">
                        Régime <span style="border: 1px solid black;padding: 30px; text-align: center;">{{ $regime_nd['code'] }}</span>
                    </th>
                    <th style="width:200px; border: none">
                        Navire <span style="border: 1px solid black;padding: 30px; text-align: center">{{$navire_nd ?? ''}}</span>
                    </th>
                    <th style="width:150px; border: none">
                        CNT <span style="border: 1px solid black;padding: 30px; text-align: center">{{$numero_connaissement ?? ''}}</span>
                    </th>
                </tr>
            </table>
        </div>

        @php
            $total_colis = 0;
            $total_poids_brut = 0;
            $total_poids_net = 0;
            $total_valeur = 0;
            $total_valeur_assurance = 0;
            $total_valeur_fret = 0;
            $data1 = $chunks[$i];
       
            for($m = 0; $m < count($data1); $m++)
            {
                $total_colis += $data1[$m]['nb_colis'];
                $total_poids_brut += $data1[$m]['poids_brut'];
                $total_poids_net += $data1[$m]['poids_net'];
                $total_valeur += $data1[$m]['valeur'];
                $total_valeur_assurance += $data1[$m]['valeur_assurance'];
                $total_valeur_fret += $data1[$m]['valeur_fret'];
            }
        @endphp

        <table class="table_css mt-32">
            <tr>
                <th style="border-top: 1px solid white !important; border-left: 1px solid white !important"></th>
                @for($count_art; $count_art <= count($data1); $count_art++)
                    <td style="width:150px">{{$start_count <= count($data) ? "Art. ".$start_count : " "}}</td>
                    @php
                        $start_count++;
                        if ($count_art === count($data1))
                        {
                            $count_art = 1;
                            break;
                        }
                    @endphp
                @endfor
            </tr>
            <tr>
                <th>Nombre De Colis |<span class="fw-bold">{{Prix_en_monetaire($total_colis)}}</span></th>
                @for($k = 0; $k < count($data1); $k++)
                    <td>{{isset($data1[$k]) ? Prix_en_monetaire($data1[$k]['nb_colis']) : ""}}</td>
                @endfor
            </tr>
            <tr>
                <th>Nomenclature Statique</th>
                @for($k = 0; $k < count($data1); $k++)
                    <td>{{isset($data1[$k]) ? $data1[$k]['nomenclature_douaniere']['code']: ""}}</td>
                @endfor
            </tr>
            <tr>
                <th>Désignation</th>
                @for($k = 0; $k < count($data1); $k++)
                    <td>{{isset($data1[$k]) ? $data1[$k]['designation'] : ""}}</td>
                @endfor
            </tr>
            <tr>
                <th>Origine</th>
                @for($k = 0; $k < count($data1); $k++)
                    <td>{{isset($data1[$k], $data1[$k]['origine']) ? $data1[$k]['origine']['nom'] : ""}}</td>
                @endfor
            </tr>
            <tr>
                <th>Provenance</th>
                @for($k = 0; $k < count($data1); $k++)
                    <td>{{isset($data1[$k], $data1[$k]['provenance']) ? $data1[$k]['provenance']['nom'] : ""}}</td>
                @endfor
            </tr>
            <tr>
                <th>Poids Brut |<span class="fw-bold">{{Prix_en_monetaire($total_poids_brut)}}</span></th>
                @for($k = 0; $k < count($data1); $k++)
                    <td>{{isset($data1[$k]) ? Prix_en_monetaire($data1[$k]['poids_brut']) : ""}}</td>
                @endfor
            </tr>
            <tr>
                <th>Poids Net |<span class="fw-bold">{{Prix_en_monetaire($total_poids_net)}}</span></th>
                @for($k = 0; $k < count($data1); $k++)
                    <td>{{isset($data1[$k]) ? Prix_en_monetaire($data1[$k]['poids_net']) : ""}}</td>
                @endfor
            </tr>
            <tr>
                <th>Nº DPI</th>
                @for($k = 0; $k < count($data1); $k++)
                    <td>{{isset($data1[$k]) ? $data1[$k]['numero_dpi'] : ""}}</td>
                @endfor
            </tr>
            <tr>
                <th>Cours Devise</th>
                @for($k = 0; $k < count($data1); $k++)
                    <td>{{isset($data1[$k]) ? $data1[$k]['nb_colis'] : ""}}</td>
                @endfor
            </tr>
            <tr>
                <th>Valeur <span class="fw-bold d-none">{{Prix_en_monetaire($total_valeur)}}</span></th>
                @for($k = 0; $k <count($data1); $k++)
                    <td>{{isset($data1[$k]) ? Prix_en_monetaire($data1[$k]['valeur'])." ".getSigne($data1[$k]['devise_id']) : ""}}</td>
                @endfor
            </tr>
            @if(isset($data1[$k]['valeur_ajustement']) && $data1[$k]['valeur_ajustement'] > 0)
                <tr>
                    <th>Ajustement</th>
                    @for($k = 0; $k < count($data1); $k++)
                        <td>{{isset($data1[$k]) ? Prix_en_monetaire($data1[$k]['valeur_ajustement']) . " ".getSigne() : ""}}</td>
                    @endfor
                </tr>
            @endif
            <tr>
                <th>Assurance |<span class="fw-bold">{{Prix_en_monetaire($total_valeur_assurance)}} {{getSigne($devise_ass_nd_id)}}</span></th>
                @for($k = 0; $k < count($data1); $k++)
                    <td>
                        {{isset($data1[$k]) ? Prix_en_monetaire($data1[$k]['valeur_assurance']). " ".getSigne($devise_ass_nd_id) : ""}}
                    </td>
                @endfor
            </tr>
            <tr>
                <th>Frais-Frêt |<span class="fw-bold">{{Prix_en_monetaire($total_valeur_fret)}} {{getSigne($devise_fret_nd_id)}}</span></th>
                @for($k = 0; $k < count($data1); $k++)
                    <td>
                        {{isset($data1[$k]) ? Prix_en_monetaire($data1[$k]['valeur_fret']). " ".getSigne($devise_fret_nd_id) : ""}}
                    </td>
                @endfor
            </tr>
            <tr>
                <th>Soit en CFA</th>
                @for($k = 0; $k < count($data1); $k++)
                    <td>{{isset($data1[$k]) ? Prix_en_monetaire($data1[$k]['valeur_caf']) : ""}}</td>
                @endfor
            </tr>
            @if (!@empty($data1[0]['valeur_mercuriale']))
                <tr>
                    <th style="border: none">Unité</th>
                    @for($k = 0; $k < count($data1); $k++)
                        <td>{{isset($data1[$k],$data1[$k]['nomenclature_douaniere'], $data1[$k]['nomenclature_douaniere']['unite_mesure'], $data1[$k]['nomenclature_douaniere']['unite_mesure']['abreviation']) ? $data1[$k]['nomenclature_douaniere']['unite_mesure']['abreviation'] : ""}}</td>
                    @endfor
                </tr>
                <tr>
                    <th style="border: none">Quantité</th>
                    @for($k = 0; $k < count($data1); $k++)
                        <td>{{isset($data1[$k]) ? Prix_en_monetaire($data1[$k]['quantite']) : ""}}</td>
                    @endfor
                </tr>
                <tr>
                    <th style="border: none">Valeur Mercuriale</th>
                    @for($k = 0; $k < count($data1); $k++)
                        <td>{{isset($data1[$k],$data1[$k]['valeur_mercuriale']) ? Prix_en_monetaire($data1[$k]['valeur_mercuriale'] * ($data1[$k]['quantite'] ?? 1) ) . ' FCFA' : ""}}</td>
                    @endfor
                </tr>
            @endif
        </table>
        
        <span style="position: absolute; bottom: 0px; right: 0px; font-size: 15px;">
            Page {{$i + 1}}/{{count($chunks)}}
        </span>


        @if(($i + 1) < count($chunks))
            <div style="page-break-before: always;"></div>
        @endif
    @endfor

    

@endsection



    


