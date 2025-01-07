<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('pages.service.index', compact('services'));
    }

    public function create()
    {
        return view('pages.service.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required'
        ]);

        Service::create($request->all());
        return redirect()->route('services.index')->with('success', 'Service créé avec succès.');
    }

    public function edit($id)
    {
        $service = Service::find($id);
        return view('pages.service.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required'
        ]);

        $service = Service::find($id);
        $service->update($request->all());
        return redirect()->route('services.index')->with('success', 'Service modifié avec succès.');
    }

    public function destroy($id)
    {
        $service = Service::find($id);
        if ($service) {
            $service->delete();
            return redirect()->route('services.index')->with('success', 'Service supprimé avec succès.');
        } else {
            return redirect()->route('services.index')->with('error', 'Service non trouvé.');
        }
    }

}