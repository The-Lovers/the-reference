<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Services;
use App\Repositories\ServicesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    protected $servicesRepository;

    public function __construct(ServicesRepository $servicesRepository)
    {
        $this->servicesRepository = $servicesRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = $this->servicesRepository->getAll();
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($locale, Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['required', 'in:0,1'],
            'is_featured' => ['required', 'in:0,1'],
            'action' => ['required', 'string'],
        ]);

        try {
            $service = Services::create([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'is_active' => (bool) $validated['is_active'],
                'is_featured' => (bool) $validated['is_featured'],
                'created_by' => Auth::id(),
            ]);

            if ($validated['action'] === 'continue') {
                return redirect()->route('services.edit', $service)
                    ->with('success', 'Service créé avec succès.');
            }

            return redirect()->route('services.index')
                ->with('success', 'Service créé avec succès.');
        } catch (\Throwable $e) {
            Log::error('Erreur création service: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur de création du service.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, Services $service)
    {
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, Services $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, Services $service)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['required', 'in:0,1'],
            'is_featured' => ['required', 'in:0,1'],
            'action' => ['required', 'string'],
        ]);

        try {
            $service->update([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'is_active' => (bool) $validated['is_active'],
                'is_featured' => (bool) $validated['is_featured'],
                'updated_by' => Auth::id(),
            ]);

            if ($validated['action'] === 'continue') {
                return redirect()->route('services.edit', $service)
                    ->with('success', 'Service modifié avec succès.');
            }

            return redirect()->route('services.index')
                ->with('success', 'Service modifié avec succès.');
        } catch (\Throwable $e) {
            Log::error('Erreur modification service: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur de modification du service.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, Services $service)
    {
        try {
            $service->delete();
            return redirect()->route('services.index')
                ->with('success', 'Service supprimé avec succès.');
        } catch (\Throwable $e) {
            Log::error('Erreur suppression service: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erreur de suppression du service.');
        }
    }
}
