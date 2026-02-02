<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>STT</title>
    <style>
        body {
            background: rgba(201, 201, 201, 0.212);
            font-family: 'Times New Roman', Times, serif;
            color: #000;
        }

        p {
            color: #000 !important;
        }

        table.main {
            border: 8px solid rgba(175, 175, 175, 0.185);
            border-radius: 16px;
            margin: 16px auto;
            background: rgba(255, 255, 255, 0.932);
        }

        p.paragraph {
            white-space: pre-line;
        }

        tr.row td {
            padding: 0 8px;
        }

        th.main--logo {
            padding: 8px 0;
        }

        a.main--link {
            color: #CBAA5D;
        }

        a.main--link:visited {
            color: #660099;
        }

        a.main--link.btn {
            display: inline-block;
            padding: 8px;
            margin: 8px 0;
            border-radius: 4px;
            background: #CBAA5D;
            color: white;
            font-weight: bolder;
            text-decoration: none;
        }

        p.paragraph-footer {
            font-size: 13px;
        }

        h1.main-heading {
            /* color: #CBAA5D; */
        }

    </style>
</head>

<body>
    <table class="main" cellpadding="0" cellspacing="0" width="80%">
        <thead>
            <tr class="row row-head">
                <th class="main--logo">

                    <img src="{{ url('logo.png') }}" alt="" width="200" height="50">
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="row row-body">
                <td>
                    <h1 class="main-heading">Demande de validation.</h1>
                </td>
            </tr>
            <tr class="row row-body">
                <td>
                    <p>Bonjour {{ $nomValidateur ?? '' }}! </p>

                    <p class="paragraph">
                        Une demande de validation est émise sur l'opération de stock : {{ $code ?? '' }} créée par {{ $nomCreateur ?? '' }}.
                    </p>
                    @if( $multiplicateur == 1)
                        <a href="{{url('/#!/detail-entreestock/'.$id)}}">Cliquez ici pour la valider.</a>
                    @else
                        <a href="{{url('/#!/detail-sortiestock/'.$id)}}">Cliquez ici pour la valider.</a>
                    @endif
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="row row-foot">
                <td>
                    <p class="paragraph paragraph-footer">La Référence du linge de maison au Sénégal
                        71, André Peytavin, Dakar
                        , Accueil : +221 33 842 80 82, SAV : +221 33 927 78 84</p>
                </td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
