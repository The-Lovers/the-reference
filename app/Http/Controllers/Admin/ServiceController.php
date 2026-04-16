<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Services;
use App\Repositories\ServicesRepository;
use App\Services\AdminActivityNotifier;
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
    public function index(Request $request)
    {
        $services = $this->servicesRepository->search($request->search);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.services.partials.listing', compact('services'))->render(),
            ]);
        }

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

            app(AdminActivityNotifier::class)->notify(Auth::user(), 'created', 'service', $service);

            if ($validated['action'] === 'continue') {
                return redirect()->route('services.edit', $service)
                    ->with('success', __('infos.service.creation-success'));
            }

            return redirect()->route('services.index')
                ->with('success', __('infos.service.creation-success'));
        } catch (\Throwable $e) {
            Log::error(__('infos.service.creation-error-log') . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', __('infos.service.creation-error'));
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

            app(AdminActivityNotifier::class)->notify(Auth::user(), 'updated', 'service', $service);

            if ($validated['action'] === 'continue') {
                return redirect()->route('services.edit', $service)
                    ->with('success', __('infos.service.edition-success'));
            }

            return redirect()->route('services.index')
                ->with('success', __('infos.service.edition-success'));
        } catch (\Throwable $e) {
            Log::error(__('infos.service.edition-error-log') . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', __('infos.service.edition-error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, Services $service)
    {
        try {
            app(AdminActivityNotifier::class)->notify(Auth::user(), 'deleted', 'service', $service);
            $service->delete();
            return redirect()->route('services.index')
                ->with('success', __('infos.service.deletion-success'));
        } catch (\Throwable $e) {
            Log::error(__('infos.service.deletion-error-log') . $e->getMessage());
            return redirect()->back()
                ->with('error', __('infos.service.deletion-error'));
        }
    }
}
