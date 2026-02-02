@extends('pdfs.layouts.layout-export')

@section('title', "Personnels")

@section('content')
<table class="table table-bordered w-100" align="center">
    <tr style="font-size: 1em;">
        <th><strong>nom</strong></th>
        <th><strong>prenom</strong></th>
        <th><strong>Contacts & Adresse</strong></th>

        <th><strong>profil</strong></th>
        <th><strong>Anciennete</strong></th>
        <th><strong>Contact d'urgence</strong></th>

    </tr>
    <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr align="center" style="font-size: 0.8em;">
            <td>{{ ucfirst( $data[$i]['nom'] ) }}</td>
            <td>{{ ucfirst( $data[$i]['prenom'] ) }}</td>
            <td>
                <ul  style="list-style-type: none; padding-left: 0;">
                    <li> {{ ucfirst( $data[$i]['telephone'] ) }}</li>
                    <li> {{ ucfirst( $data[$i]['email'] ) }}</li>
                    <li> {{ ucfirst( $data[$i]['adresse'] ) }}</li>
                </ul>
            </td>

            <td>{{ ucfirst($data[$i]['role']['name'] ?? 'null') }}</td>
            <td>{{ ucfirst( $data[$i]['anciennete'] ) }}</td>

            <td>
                <p>{{ ucfirst( $data[$i]['nomcp'] ) }}</p>
                <p>{{ ucfirst( $data[$i]['fonction'] ) }}</p>
                <p>{{ ucfirst( $data[$i]['telephonecp'] ) }}</p>
            </td>
            </tr>
            @endfor
    </tbody>
</table>
@endsection