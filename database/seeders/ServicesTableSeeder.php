<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ServicesTableSeeder extends Seeder
{
    public function run()
    {
        // Chemin vers le fichier SQL
        $sqlFile = public_path('services.sql');

        // Vérifier si le fichier existe
        if (File::exists($sqlFile)) {
            // Lire le contenu du fichier
            $sql = File::get($sqlFile);

            // Exécuter les requêtes SQL
            DB::unprepared($sql);

            echo "Importation des services terminée avec succès.\n";
        } else {
            echo "Erreur : le fichier services.sql est introuvable.\n";
        }
    }
}