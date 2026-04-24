<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Missions;
use App\Repositories\MissionsRepository;
use App\Services\AdminActivityNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MissionController extends Controller
{
    protected $missionRepository;

    public function __construct(
        MissionsRepository $missionRepository,
    ) {
        $this->missionRepository = $missionRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $missions = $this->missionRepository->search($request->search);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.missions.partials.listing', compact('missions'))->render(),
            ]);
        }

        return view('admin.missions.index', compact('missions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $icons = random_icon_classes();

        return view('admin.missions.create', compact('icons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($locale, Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['required', 'string', 'max:255'],
            'status' => ['required ', 'in:0,1'],
            'is_featured' => ['required ', 'in:0,1'],
            'action' => ['required', 'string'],
            'cover'  => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ]);

        try {
            // Préparer l'icône
            if (!str_starts_with($validated['icon'], 'fa-')) {
                $validated['icon'] = "fa-solid fa-" . $validated['icon'];
            }

            $mission = null;
            DB::transaction(function () use (&$validated, $request, $user, &$mission) {
                // Upload image
                if ($request->hasFile('cover')) {
                    $file = $request->file('cover');
                    $filename = 'mission_' . time() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/missions'), $filename);
                }
                $validated['cover'] = 'uploads/missions/' . $filename;
                // Création de la mission
                $mission = new Missions($validated);
                $mission->creator()->associate($user);
                $mission->save();
            });

            app(AdminActivityNotifier::class)->notify($user, 'created', 'mission', $mission);

            // Gestion des boutons
            $action = $validated['action'];
            if ($action === 'continue') {
                return redirect()->route('missions.create')->with('success', __('missions.create.success-next'));
            }

            return redirect()->route('missions.index')->with('success', __('missions.create.success'));

        } catch (\Throwable $e) {
            // Log l'erreur
            Log::error(__('missions.create.error') . ': ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', __('missions.create.error') . ': ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, Missions $mission)
    {
        return view('admin.missions.show', compact('mission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, Missions $mission)
    {
        $icons = random_icon_classes(currentIcon: $mission->icon);

        return view('admin.missions.edit', compact('mission', 'icons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, Missions $mission)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:0,1'],
            'is_featured' => ['required', 'in:0,1'],
            'action' => ['required', 'string'],
            'cover'  => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ]);

        try {
            // Préparer l'icône
            if (!str_starts_with($validated['icon'], 'fa-')) {
                $validated['icon'] = "fa-solid fa-" . $validated['icon'];
            }

            DB::transaction(function () use (&$validated, $request, $user, $mission) {
                // Gestion du cover
                if ($request->hasFile('cover')) {
                    // Supprimer l'ancien cover s'il existe
                    if ($mission->cover && file_exists(public_path($mission->cover))) {
                        unlink(public_path($mission->cover));
                    }

                    $file = $request->file('cover');
                    $filename = 'mission_' . time() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/missions'), $filename);
                    $validated['cover'] = 'uploads/missions/' . $filename;
                }

                // Mettre à jour la mission
                $mission->fill($validated);
                $mission->updater()->associate($user);
                $mission->save();
            });

            app(AdminActivityNotifier::class)->notify($user, 'updated', 'mission', $mission);

            // Gestion des boutons
            $action = $validated['action'];
            if ($action === 'continue') {
                return redirect()->route('missions.edit', $mission)->with('success', __('missions.update.success-next'));
            }

            return redirect()->route('missions.index')->with('success', __('missions.update.success'));

        } catch (\Throwable $e) {
            Log::error(__('missions.update.error') . ': ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', __('missions.update.error') . ': ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, Missions $mission)
    {
        try {
            app(AdminActivityNotifier::class)->notify(Auth::user(), 'deleted', 'mission', $mission);
            DB::transaction(function () use ($mission) {
                // Supprimer le cover si il existe
                if ($mission->cover && file_exists(public_path($mission->cover))) {
                    unlink(public_path($mission->cover));
                }

                // Supprimer la mission
                $mission->delete();
            });

            return redirect()->route('missions.index')->withInput()->with('success', __('missions.delete.success'));

        } catch (\Throwable $e) {
            Log::error(__('missions.delete.error') . ': ' . $e->getMessage());

            return redirect()->back()->with('error', __('missions.delete.error') . ': ' . $e->getMessage());
        }
    }

    public function updateStatus($locale, Missions $mission, $value)
    {
        $mission->update([
            'status' => $value,
            'status_updated_by' => Auth::id(),
        ]);

        app(AdminActivityNotifier::class)->notify(
            Auth::user(),
            (int) $value === 1 ? 'published' : 'unpublished',
            'mission',
            $mission
        );

        return redirect()->back()
                ->withInput()
                ->with('success', __('missions.index.status.success'));
    }

    public function updateFeatured($locale, Missions $mission, $value)
    {
        $mission->update([
            'is_featured' => $value,
            'featured_updated_by' => Auth::id(),
        ]);

        app(AdminActivityNotifier::class)->notify(
            Auth::user(),
            (int) $value === 1 ? 'featured' : 'unfeatured',
            'mission',
            $mission
        );

        return redirect()->back()
                ->withInput()
                ->with('success', __('missions.index.featured.success'));
    }
}
