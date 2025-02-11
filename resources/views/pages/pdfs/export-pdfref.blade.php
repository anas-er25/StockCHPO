<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matériels Réformés</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e2e2e2;
        }

        td {
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
    <h1>Matériels Réformés</h1>
    <table>
        <thead>
            <tr>
                <th>N° d'inventaire</th>
                <th>Quantité</th>
                <th>Motif</th>
                <th>Désignation</th>
                <th>Fait le</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materiels as $materiel)
                <tr>
                    <td>{{ $materiel->material_id ? $materiel->materiel->num_inventaire : 'N/A' }}</td>
                    <td>{{ $materiel->qte }}</td>
                    <td>{{ $materiel->motif }}</td>
                    <td>{{ $materiel->designation }}</td>
                    <td>{{ $materiel->updated_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
