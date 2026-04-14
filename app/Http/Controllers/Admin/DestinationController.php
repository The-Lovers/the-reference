<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Destination;
use App\Repositories\DestinationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DestinationController extends Controller
{
    protected $destinationRepository;

    public function __construct(DestinationRepository $destinationRepository)
    {
        $this->destinationRepository = $destinationRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinations = $this->destinationRepository->getAll();
        return view('admin.destinations.index', compact('destinations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::orderBy('label_fr')->get();
        return view('admin.destinations.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($locale, Request $request)
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'country_id' => ['required', 'exists:countries,id'],
            'is_available' => ['required', 'in:0,1'],
            'action' => ['required', 'string'],
        ]);

        try {
            $destination = Destination::create([
                'label' => $validated['label'],
                'description' => $validated['description'] ?? null,
                'country_id' => $validated['country_id'],
                'is_available' => (bool) $validated['is_available'],
            ]);

            if ($validated['action'] === 'continue') {
                return redirect()->route('destinations.edit', $destination)
                    ->with('success', 'Destination créée avec succès.');
            }

            return redirect()->route('destinations.index')
                ->with('success', 'Destination créée avec succès.');
        } catch (\Throwable $e) {
            Log::error('Erreur création destination: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur de création de la destination.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, Destination $destination)
    {
        $destination->load('pays');
        return view('admin.destinations.show', compact('destination'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, Destination $destination)
    {
        $countries = Country::orderBy('label_fr')->get();
        return view('admin.destinations.edit', compact('destination', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'country_id' => ['required', 'exists:countries,id'],
            'is_available' => ['required', 'in:0,1'],
            'action' => ['required', 'string'],
        ]);

        try {
            $destination->update([
                'label' => $validated['label'],
                'description' => $validated['description'] ?? null,
                'country_id' => $validated['country_id'],
                'is_available' => (bool) $validated['is_available'],
            ]);

            if ($validated['action'] === 'continue') {
                return redirect()->route('destinations.edit', $destination)
                    ->with('success', 'Destination modifiée avec succès.');
            }

            return redirect()->route('destinations.index')
                ->with('success', 'Destination modifiée avec succès.');
        } catch (\Throwable $e) {
            Log::error('Erreur modification destination: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur de modification de la destination.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, Destination $destination)
    {
        try {
            $destination->delete();
            return redirect()->route('destinations.index')
                ->with('success', 'Destination supprimée avec succès.');
        } catch (\Throwable $e) {
            Log::error('Erreur suppression destination: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erreur de suppression de la destination.');
        }
    }
}
