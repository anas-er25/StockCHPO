<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste du matériel proposé à la réforme</title>
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

        header h2,
        header h3 {
            text-align: center;
            margin: 5px 0;
            /* Espacement entre les éléments */
        }

        .header img {
            width: 100%;
            /* Ajustez la largeur de l'image de l'en-tête */
            max-width: 800px;
            /* Limitez la largeur maximale */
            height: 100px;
            /* Gardez le ratio de l'image */
        }

        .footer img {
            width: 100%;
            /* Ajustez la largeur de l'image du pied de page */
            max-width: 800px;
            /* Limitez la largeur maximale */
            height: 80px;
            /* Gardez le ratio de l'image */
            margin-top: 20px;
            /* Espacement au-dessus du pied de page */
        }

        .right {
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th {
            padding: 10px;
            text-align: center;
        }

        td {
            padding: 20px;
        }

        .designation {
            width: 40%;
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
    <!-- En-tête avec l'image header.png -->
    <div class="header">
        <img src="{{ public_path('assets/images/pdf/header.png') }}" alt="En-tête">
    </div>
    <header >
        <h2>Liste du matériel proposé à la réforme</h2>
        <h3>Service/Unité : ................ Année : {{ date('Y') }}/{{ date('Y') + 1 }}</h3>
    </header>
    <table>
        <thead>
            <tr>
                <th class="designation">Désignation</th>
                <th>Quantité</th>
                <th>Motifs de réforme</th>
                <th>N° d'inventaire</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="designation"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="designation"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="designation"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="designation"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="designation"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="designation"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="designation"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="designation"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="designation"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="designation"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="designation"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

        </tbody>
    </table>
    <div class="signature">
        <div>Signature </div>
        <div>le : ................</div>
    </div>
    <!-- Pied de page avec l'image footer.png -->
    <div class="footer">
        <img src="{{ public_path('assets/images/pdf/footer.png') }}" alt="Pied de page">
    </div>
</body>

</html>
