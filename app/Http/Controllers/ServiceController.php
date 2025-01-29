<?php

namespace App\Http\Controllers;

use App\Models\Hopital;
use App\Models\Log;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('pages.service.index', compact('services'));
    }

    public function create()
    {
        $hopitals = Hopital::all();
        return view('pages.service.create', compact('hopitals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|unique:services',
            'hopital_id' => 'required'
        ]);

        // Créer le service
        $service = Service::create($request->all());

        // Créer le log
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
        return view('pages.service.edit', compact('service', 'hopitals'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|unique:services',
            'hopital_id' => 'required'
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