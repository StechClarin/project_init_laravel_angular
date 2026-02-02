
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport d'Assistance Technique et d'Exploitation</title>
    <style>
        img {
                display: block !important;
                visibility: visible !important;
                max-width: 100%;
                height: auto;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .underline {
            text-decoration: underline;
        }
        .table-custom {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table-custom th, .table-custom td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .table-custom th {
            background-color: #f2f2f2;
        }
        .page {
            page-break-after: always; 
            margin-bottom: 2rem; 
            width: 100%; ;
        }
        .icon {
            width: 20px;
            height: 20px;
            display: inline-block;
            margin-right: 5px;
        }
        .content h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .content h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .content h4 {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .content h5 {
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .content ul li {
            margin-bottom: 5px;
        }
        /* Styles pour le tableau horizontal */
        .table-horizontal {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table-horizontal td {
            border: 1px solid #000;
            padding: 50px;
            text-align: center;
            vertical-align: middle;
        }
        .table-horizontal td  h2,p {
            padding: -20px;
            font-size: 14px;
        }
        .table-horizontal td:first-child {
            font-weight: bold;
            background-color: #f2f2f2; /* Fond gris pour la première case */
        }
        .table-horizontal td:nth-child(2) {
            font-style: italic; /* Texte en italique pour la deuxième case */
        }
        .table-horizontal td:last-child {
            font-size: 16px; /* Taille de police réduite pour la date */
        }

        /* Styles pour le reste du document */
        .content {
            margin-top: 40%;
            margin-bottom: 32%;
        }
        .content h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .content p {
            margin: 0;
        }
        .header {  
            position: fixed;  
            top: 0;  
            left: 0;  
            right: 0;  
            height: 50px;  
            text-align: center;  
            line-height: 35px;   
        }   
        
        .footer p {  
            font-size: 10px; 
            text-align:center; 
        }   

        
        .footer a {
            color: #555;
            text-decoration: none;
            ;
        }
        .footer a:hover {
            text-decoration: underline;
        }

        /* header */
        .footer {  
            position: fixed;  
            bottom: 0;  
            left: 0;  
            right: 0;  
            height: 50px;  
            text-align: center;  
            line-height: 35px; 
        }  

        /* Style pour le logo */  
        .logo-container {  
            margin: 0 auto;  
            max-width: 300px;  
        }  

        .logo {  
            max-width: 100%;  
            height: auto;  
        }  

        /* Style pour le nom de l'entreprise et le sous-titre */  
        .company-name {  
            margin: 15px 0;  
            font-size: 24px;  
            font-weight: bold;  
        }  

        .subtitle {  
            margin: 5px 0;  
            font-size: 18px;  
            color: #666;  
        }  

        /* Style pour la ligne avec la section colorée */  
        .header-line {  
            width: 80%;  
            margin: 15px auto;  
            height: 2px;  
            background-color: #ddd;  
            position: relative;  
        }  

        .teal-section {  
            width: 80px;  
            height: 100%;  
            background-color: #009688; /* Couleur teal */  
            margin: 0 auto;  
        }  

        /* Ajoutez ces styles si vous avez une image logo */  
        .logo-container img {  
            max-width: 100%;  
            height: auto;  
        } 
        .page-2-content {  
            margin-top: 100px; 
            margin-bottom: 60px;
        }
        .page-2-content h2 {
            font-size: 20px;
            margin-bottom: 10px;
            text-align: center;
            font-style: italic;
        }
        .page-2-content h4 {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .page-2-content h5 {
            font-size: 14px;
            margin-bottom: 10px;
        }
        .page-2-content ul {
            margin: 0;
            padding-left: 20px;
        }
        .page-2-content ul li {
            margin-bottom: 5px;
        }
        .page-2-content .table-custom {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .page-2-content .table-custom th, .page-2-content .table-custom td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .page-2-content .table-custom th {
            background-color: #f2f2f2;
        }
        @media print {  
            img {
                display: block !important;
                visibility: visible !important;
                max-width: 100%;
                height: auto;
            }
         
            .logo {  
                -webkit-print-color-adjust: exact;  
                color-adjust: exact;  
                forced-color-adjust: none;  
            }  
            .logo-container img {  
                max-width: 100%;  
                height: auto;  
            }
        } 
         
    </style>
</head>
<body>
    <div class="page">
        <div class="header">  
            <div class="logo-container"> 
                <img src="{{ asset('assets/media/logos/guindy.png') }}" alt="Logo de l'entreprise" class="logo" style="width: 100px;">  
            </div> 
            <div class="header-line">  
                <div class="teal-section"></div>  
            </div>  
        </div> 

        <div class="content">
            @for ($i = 0; $i < count($data); $i++)
                @php
                    $projet = $data[$i]['projet']['nom'];
                @endphp
                <table class="table-horizontal">
                    <tr>
                        <td><h1>{{$projet}}</h1></td>
                        <td><h2>{{$data[$i]['libelle']}}</h2><br>Fait le {{$data[$i]['date_fr']}}</td>
                       <td>
                       <img src="{{ asset('assets/media/logos/logo.svg') }}" class="logo" style="width: 100px;">  

                       </td>
                
                    </tr>
                </table>

                <!-- Contenu principal -->
                <table class="table-horizontal">
                    <tr>
                        <td>
                            <h2>OBJET :</h2>
                        </td>
                        <td>
                            <h2>Rapport mensuel d'assistance technique et d'exploitation</h2>
                            @if (count($data[$i]['details_assistance']) > 0)
                                @php
                                    $firstDate = null;
                                    $firstDate = $data[$i]['details_assistance'][0]['assistance']['date_fr'] ?? null;
                                    $lastDate = $data[$i]['details_assistance'][count($data[$i]['details_assistance']) - 1]['assistance']['date_fr'] ?? null;
                                @endphp

                                @if ($firstDate && $lastDate)
                                    <p>
                                        Du <span>{{ $firstDate }}</span>
                                        @if($firstDate != $lastDate) 
                                            au <span>{{ $lastDate }}</span>
                                        @endif
                                    </p>
                                @else
                                    <p>Les dates ne sont pas disponibles.</p>
                                @endif
                            @else
                                <p>Aucune assistance trouvée.</p>
                            @endif
                        </td>
                    </tr>
                </table>
            @endfor
        </div>

        <div class="footer">  
            <div class="header-line">  
                <div class="teal-section"></div>  
                <p>+221 33 824 87 89  Zone A, 71 A Dakar (SENEGAL) <a href="mailto:contactsg@quindytechnology.com">contactsg@quindytechnology.com</a> <a href="http://www.quindytechnology.com">www.quindytechnology.com</a></p> 
            </div> 
            
        </div>  
    </div>
    
    <div class="page">
        <div class="header">  
            <div class="logo-container"> 
                <img src="{{ asset('assets/media/logos/guindy.png') }}" alt="Logo de l'entreprise" class="logo">  
            </div> 
            <div class="header-line">  
                <div class="teal-section"></div>  
            </div>  
        </div> 

        <div class="page-2-content">
            <h2>Introduction</h2>
            <p>Ce document liste les différentes tâches exécutées en assistance technique et d'exploitation pour la période définie ci-dessous concernant votre projet Digital : <b>{{$projet}}</b></p>
                <table  class="table-custom">
                    <thead>
                        <tr>
                            <th style="text-align: center;">
                                <h4>FICHE D'INTERVENTION DU MOIS DE  
                                    <?php echo strtoupper( date('F', strtotime($firstDate))); ?>
                                    @if($firstDate != $lastDate) 
                                        AU <?php echo  strtoupper( date('F', strtotime($lastDate))); ?>
                                    @endif
                                </h4>  
                            </th>
                        </tr>
                    </thead>
                </table>
            <h5 class="underline">Tâches régulières (1.5J)</h5>
            <ul>
                <li>Backup des bases de données sur les plateformes de versionning pour un suivi incrémentiel.</li>
                <li>Restauration des deux dernières bases de données pour se rassurer de l'intégrité des sauvegardes.</li>
                <li>Snapshots complets des serveurs et suppression des précédents snapshots pour ajuster l'espace disponible.</li>
                <li>Vérification et suivi des logs pour capturer les alertes systèmes répétitifs pour analyse et ajustements techniques.</li>
                <li>Surveillance des performances (CPU, mémoire, réseau...) pour rééquilibrer les paramètres de charge au niveau du serveur d'applications, du SGBD, du runtime...</li>
            </ul>

            <h5 class="underline">Demandes ponctuelles</h5>
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>DATE</th>
                        <th>TYPE</th>
                        <th>DESCRIPTION</th>
                        <th>ETAT</th>
                        <th>DURÉE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item )
                        @foreach ($item['details_assistance'] as $details )
                            @if($details['assistance_id'] == $details['assistance']['id'])
                                <tr>

                                    <td>{{ $details['assistance']['date_fr']}}</td>
                                    <td>{{ $details['assistance']['type_tache']['nom']}}</td>
                                    <td>{{ $details['assistance']['detail']}}</td>
                                    <td>
                                        @if($details['assistance']['status'] == 0)<span>En cours</span>@endif
                                        @if($details['assistance']['status']  == 1)<span>En attente</span>@endif
                                        @if($details['assistance']['status']  == 2)<span>Cloturé</span>@endif
                                    </td>
                                    @if($details['assistance']['duree'] !== null) 
                                        <td>{{ $details['assistance']['duree']}} min</td>
                                    @else
                                        <td> -- </td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach
                       
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer">  
            <div class="header-line">  
                <div class="teal-section"></div>  
                <p>+221 33 824 87 89  Zone A, 71 A Dakar (SENEGAL) <a href="mailto:contactsg@quindytechnology.com">contactsg@quindytechnology.com</a> <a href="http://www.quindytechnology.com">www.quindytechnology.com</a></p> 
            </div> 
        </div>  
    </div>
</body>