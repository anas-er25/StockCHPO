<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Material;
use App\Models\Societe;
use App\Models\SocieteMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SocieteController extends Controller
{
    public function index()
    {
        $societies = Societe::all();
        return view('pages.societe.index', ['societies' => $societies]);
    }

    public function edit($id)
    {
        $societe = Societe::find($id);
        return view('pages.societe.edit', ['societe' => $societe]);
    }

    public function update(Request $request, $id)
    {
        // validate the form
        $request->validate([
            'nom_societe' => 'required',
            'telephone' => 'required',
        ]);

        // update the data
        $societe = Societe::find($id);
        $societe->nom_societe = $request->nom_societe;
        $societe->siege_social = $request->siege_social;
        $societe->telephone = $request->telephone;

        if ($societe->save()) {
            // create log
            Log::create([
                'action' => 'update',
                'table_name' => 'societies',
                'record_id' => $societe->id,
                'performed_by' => Auth::user()->id,
                'performed_at' => now()
            ]);
        }

        return redirect()->route('societies.index')->with('success', 'Société modifié avec succès.');
    }

    public function destroy($id)
    {
        $societe = Societe::find($id);
        // Check authorization using Gate
        if (Gate::denies('delete', $societe)) {
            abort(403, 'Action non autorisée.');
        }
        if ($societe->delete()) {
            // create log
            Log::create([
                'action' => 'delete',
                'table_name' => 'societies',
                'record_id' => $societe->id,
                'performed_by' => Auth::user()->id,
                'performed_at' => now()
            ]);
        }

        return redirect()->route('societies.index')->with('success', 'Société supprimé avec succès.');
    }

    public function importSociete(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());

        foreach ($spreadsheet->getAllSheets() as $sheet) {
            $rows = [];
            foreach ($sheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                $rowData = [];
                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue();
                }
                $rows[] = $rowData;
            }

            // Ignorer la première ligne (en-têtes)
            array_shift($rows);

            foreach ($rows as $row) {
                // Valider chaque ligne
                $validator = Validator::make([
                    'Nom de société' => $row[0],
                ], [
                    'Nom de société' => 'required|string',
                ]);

                if ($validator->fails()) {
                    // Gérer les erreurs de validation ici
                    continue;
                }
                // Vérifier si la société existe, sinon la créer
                $societe = Societe::firstOrCreate([
                    'nom_societe' => $row[0],
                ], [
                    'siege_social' => null,
                    'telephone' => null,
                    'nombre_articles' => 0,
                ]);

                // Récupérer le matériel par son numéro d'inventaire
                $num_inventaire = $row[6];
                $material = Material::where('num_inventaire', $num_inventaire)->first();

                if ($material) {
                    // Créer l'association entre la société et le matériel
                    SocieteMaterial::firstOrCreate([
                        'societe_id' => $societe->id,
                        'material_id' => $material->id,
                    ], [
                        'numero_marche' => $row[1] ?? null,
                        'numero_bl' => $row[2] ?? null,
                        'PV' => $row[3] ?? null,
                        'CPS' => $row[11] ?? null,
                        'observation' => 'rien à signalé',
                    ]);
                }
            }
        }

        return back()->with('success', 'Données importées avec succès.');
    }
}