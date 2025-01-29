<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avis de Mouvement</title>
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

        .header img {
            width: 100%;
            /* Ajustez la largeur de l'image de l'en-tête */
            max-width: 800px;
            /* Limitez la largeur maximale */
            height: auto;
            /* Gardez le ratio de l'image */
        }

        .footer img {
            width: 100%;
            /* Ajustez la largeur de l'image du pied de page */
            max-width: 800px;
            /* Limitez la largeur maximale */
            height: auto;
            /* Gardez le ratio de l'image */
            margin-top: 20px;
            /* Espacement au-dessus du pied de page */
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
            margin-top: 30px;
            width: 100%;
        }

        .signature div {
            text-align: center;
            margin-top: 10px;
        }

        .signature div:nth-child(1) {
            text-align: left;
            margin-top: 20px;
        }

        .signature div:nth-child(2) {
            text-align: right;
            margin-top: 20px;
        }

        .signature div:nth-child(3),
        .signature div:nth-child(4) {
            text-align: center;
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
    @foreach ($avismvts as $avismvt)
        <!-- En-tête avec l'image header.png -->
        <div class="header">
            <img src="{{ public_path('assets/images/pdf/header.png') }}" alt="En-tête">
        </div>
        <div class="header">
            <h2>Avis de Mouvement</h2>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Désignation</th>
                    <th>Quantité</th>
                    <th>N° d'inventaire</th>
                    <th>Cédant</th>
                    <th>Cessionnaire</th>
                    <th>Motif de mouvement</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $avismvt->material_id ? $avismvt->materiel->designation : 'N/A' }}</td>
                    <td>{{ $avismvt->qte }}</td>
                    <td>{{ $avismvt->material_id ? $avismvt->materiel->num_inventaire : 'N/A' }}
                    </td>
                    <td>{{ $avismvt->cedant_id ? $avismvt->cedant->nom : 'N/A' }}</td>
                    <td>{{ $avismvt->cessionnaire_id ? $avismvt->cessionnaire->nom : 'N/A' }}</td>
                    <td>{{ $avismvt->motif }}</td>
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
                <div><u>{{ $avismvt->cessionnaire_id ? $avismvt->cessionnaire->nom : 'N/A' }}</u></div>
                <div><u>{{ $avismvt->cedant_id ? $avismvt->cedant->nom : 'N/A' }}</u></div>
            </div>
            <div>
                <div><u>Chef PAA</u></div>
                <div><u>Le Directeur du CHPO </u></div>
            </div>
        </div>
        <div class="subsignature">
            <h4><u>Ampliations:</u></h4>
            <ul>
                <li>
                    {{ $avismvt->cedant_id ? $avismvt->cedant->nom : 'N/A' }}
                </li>
                <li>
                    Bureau materiel
                </li>
                <li>
                    Archives
                </li>
            </ul>
        </div>
        <!-- Pied de page avec l'image footer.png -->
        <div class="footer">
            <img src="{{ public_path('assets/images/pdf/footer.png') }}" alt="Pied de page">
        </div>

        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>
