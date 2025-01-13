<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin de Cession</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .header {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .right {
            text-align: right;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: center;
            border: 1px solid #000;
        }

        .signature {
            display: flex;
            justify-content: space-between;
            /* Aligner les divs à gauche et à droite */
            margin-top: 30px;
            width: 100%;
            /* S'assurer que l'élément prend toute la largeur disponible */
        }

        .signature div {
            text-align: center;
            /* Centrer le texte dans chaque div */
            margin-top: 10px;
        }

        .signature div:nth-child(1) {
            text-align: left;
            /* Aligné à gauche */
            margin-top: 20px;

        }

        .signature div:nth-child(2) {
            text-align: right;
            /* Aligné à droite */
            margin-top: 20px;
        }

        .signature div:nth-child(3),
        .signature div:nth-child(4) {
            text-align: center;
            /* Centrer les autres signatures */
            margin-top: 100px;
        }

        .subsignature {
            margin-top: 50px;

        }

        .subsignature h4 {
            margin-bottom: 10px;
        }

        .subsignature ul {
            padding: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 100px;
            font-size: 10px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Bulletin de Cession</h2>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Désignation</th>
                <th>Quantité</th>
                <th>Numéro d'inventaire</th>
                <th>Numéro de série</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Cédant</th>
                <th>Cessionnaire</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $material->designation }}</td>
                <td>{{ $material->qte }}</td>
                <td>{{ explode('/', $material->num_inventaire)[0] }}</td>
                <td>{{ $material->num_serie }}</td>
                <td>{{ $material->marque }}</td>
                <td>{{ $material->modele }}</td>
                <td>CHPO <br> Bureau de matériel</td>
                <td>{{ $material->service ? $material->service->nom : 'N/A' }}</td>
            </tr>
        </tbody>
    </table>
    <div class="right">
        <p>
            <u>
                Fait à Ouarzazate, le {{ Carbon\Carbon::now()->format('d/m/Y') }}
            </u>
        </p>
    </div>

    <div class="signature">
        <div>
            <div><u>Bureau matériel </u></div>
            <div><u>{{ $material->service ? $material->service->nom : 'N/A' }} </u></div>
        </div>
        <div>
            <div><u>Chef PAA </u></div>
            <div><u>Le Directeur du CHPO </u></div>
        </div>
    </div>
    <div class="subsignature">
        <h4><u>Ampliations:</u></h4>
        <ul>
            <li>
                {{ $material->service ? $material->service->nom : 'N/A' }}
            </li>
            <li>
                Archives
            </li>
        </ul>
    </div>
    <div class="footer">
        <hr>
        <p>Centre Hospitalier Provincial de Ouarzazate - Tel : (05)24.88.21.22 - Fax : (05)24.88.21.22</p>
        <p>E-mail: chp.ozte@gmail.com</p>
    </div>

</body>

</html>
