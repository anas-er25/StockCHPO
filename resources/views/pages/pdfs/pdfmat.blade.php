<!DOCTYPE html>
<html>
<head>
    <title>Liste de matériels</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Liste de matériels</h1>
    <table>
        <thead>
            <tr>
                <th>N° d'inventaire</th>
                <th>Date d'inscription</th>
                <th>Désignation</th>
                <th>Quantité</th>
                <th>N° de série</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Affectation</th>
                <th>Date d'affectation</th>
                <th>Observation</th>
                <th>Nom de société</th>
                <th>N° du marché</th>
                <th>N° de BL</th>
                <th>Type</th>
                <th>Origine</th>
                <th>État</th>
            </tr>
        </thead>
        <tbody>
            {{-- @dd($materiels) --}}
            @foreach($materiels as $material)
                <tr>
                    <td>{{ $material->num_inventaire }}</td>
                    <td>{{ $material->date_inscription }}</td>
                    <td>{{ $material->designation }}</td>
                    <td>{{ $material->qte }}</td>
                    <td>{{ $material->num_serie }}</td>
                    <td>{{ $material->marque }}</td>
                    <td>{{ $material->modele }}</td>
                    <td>{{ $material->service ? $material->service->nom : 'N/A' }}</td>
                    <td>{{ $material->date_affectation }}</td>
                    <td>{{ $material->observation }}</td>
                    <td>{{ $material->societe ? $material->societe->nom_societe : 'N/A' }}</td>
                    <td>{{ $material->societeMaterials->first() ? $material->societeMaterials->first()->numero_marche : 'N/A' }}</td>
                    <td>{{ $material->societeMaterials->first() ? $material->societeMaterials->first()->numero_bl : 'N/A' }}</td>
                    <td>{{ $material->type }}</td>
                    <td>{{ $material->origin }}</td>
                    <td>{{ $material->etat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
