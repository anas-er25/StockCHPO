<?php

namespace App\Http\Controllers;

use App\Models\Hopital;
use App\Models\Log;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::whereNull('parent_id')->get();
        return view('pages.service.index', compact('services'));
    }

    public function create()
    {
        $hopitals = Hopital::all();
        $services = Service::whereNull('parent_id')->with('hopital')->get();

        return view('pages.service.create', compact('hopitals', 'services'));
    }
    public function getSubServices($parentId)
    {
        $subServices = Service::where('parent_id', $parentId)->get();
        return response()->json($subServices);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => [
                'required',
                Rule::unique('services')->where(function ($query) use ($request) {
                    return $query->where('hopital_id', $request->hopital_id)
                        ->where('parent_id', $request->parent_id);
                })
            ],
            'hopital_id' => 'required|exists:hopitals,id',
            'parent_id' => 'nullable|exists:services,id'
        ]);


        // Create the service
        $service = Service::create($request->all());

        // Create the log
        Log::create([
            'action' => 'create',
            'table_name' => 'services',
            'record_id' => $service->id,
            'performed_by' => Auth::user()->id,
            'performed_at' => now()
        ]);

        return redirect()->route('services.index')->with('success', 'Service créé avec succès.');
    }


    public function edit($id)
    {
        $hopitals = Hopital::all();
        $service = Service::find($id);
        $services = Service::whereNull('parent_id')->get();
        return view('pages.service.edit', compact('services', 'service', 'hopitals'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => [
                'required',
                Rule::unique('services')->where(function ($query) use ($request) {
                    return $query->where('hopital_id', $request->hopital_id)
                        ->where('parent_id', $request->parent_id);
                })
            ],
            'hopital_id' => 'required|exists:hopitals,id',
            'parent_id' => 'nullable|exists:services,id'
        ]);

        $service = Service::find($id);
        $service->update($request->all());
        // Créer le log
        Log::create([
            'action' => 'update',
            'table_name' => 'services',
            'record_id' => $service->id,
            'performed_by' => Auth::user()->id,
            'performed_at' => now()
        ]);
        return redirect()->route('services.index')->with('success', 'Service modifié avec succès.');
    }

    public function show($id)
    {
        // Trouver le service principal
        $service = Service::findOrFail($id);

        // Récupérer les sous-services (enfants) du service principal
        $SousServices = $service->children;

        // Retourner la vue avec les sous-services
        return view('pages.service.show', compact('SousServices'));
    }


    public function destroy($id)
    {
        $service = Service::find($id);
        // Check authorization using Gate
        if (Gate::denies('delete', $service)) {
            abort(403, 'Action non autorisée.');
        }
        if ($service) {
            $service->delete();
            // Créer le log
            Log::create([
                'action' => 'delete',
                'table_name' => 'services',
                'record_id' => $service->id,
                'performed_by' => Auth::user()->id,
                'performed_at' => now()
            ]);
            return redirect()->route('services.index')->with('success', 'Service supprimé avec succès.');
        } else {
            return redirect()->route('services.index')->with('error', 'Service non trouvé.');
        }
    }
}