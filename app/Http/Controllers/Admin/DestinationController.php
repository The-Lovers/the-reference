<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Destination;
use App\Repositories\DestinationRepository;
use App\Services\AdminActivityNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
    public function index(Request $request)
    {
        $destinations = $this->destinationRepository->search($request->search);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.destinations.partials.listing', compact('destinations'))->render(),
            ]);
        }

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

            app(AdminActivityNotifier::class)->notify(Auth::user(), 'created', 'destination', $destination);

            if ($validated['action'] === 'continue') {
                return redirect()->route('destinations.edit', $destination)
                    ->with('success', __('infos.destination.creation-success'));
            }

            return redirect()->route('destinations.index')
                ->with('success', __('infos.destination.creation-success'));
        } catch (\Throwable $e) {
            Log::error(__('infos.destination.creation-error-log') . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', __('infos.destination.creation-error'));
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

            app(AdminActivityNotifier::class)->notify(Auth::user(), 'updated', 'destination', $destination);

            if ($validated['action'] === 'continue') {
                return redirect()->route('destinations.edit', $destination)
                    ->with('success', __('infos.destination.edition-success'));
            }

            return redirect()->route('destinations.index')
                ->with('success', __('infos.destination.edition-success'));
        } catch (\Throwable $e) {
            Log::error(__('infos.destination.edition-error-log') . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', __('infos.destination.edition-error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, Destination $destination)
    {
        try {
            app(AdminActivityNotifier::class)->notify(Auth::user(), 'deleted', 'destination', $destination);
            $destination->delete();
            return redirect()->route('destinations.index')
                ->with('success', __('infos.destination.deletion-success'));
        } catch (\Throwable $e) {
            Log::error(__('infos.destination.deletion-error-log') . $e->getMessage());
            return redirect()->back()
                ->with('error', __('infos.destination.deletion-error'));
        }
    }
}
