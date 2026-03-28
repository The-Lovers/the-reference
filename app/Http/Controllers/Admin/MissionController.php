<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Missions;
use App\Repositories\MissionsRepository;
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
    public function index()
    {
        $missions = $this->missionRepository->getAll();
        return view('admin.missions.index', compact('missions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lines = file(storage_path('app/icons.txt'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $icons = array_map(function($line) {
            return trim($line, " \t\n\r\","); // supprime espaces, guillemets et virgules
        }, $lines);
        // Mélanger et prendre 40 lignes
        shuffle($icons);
        $icons = array_slice($icons, 0, 45);
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
            $validated['icon'] = "fa-solid fa-" . $validated['icon'];

            DB::transaction(function () use (&$validated, $request, $user) {
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

            // Gestion des boutons
            $action = $validated['action'];
            if ($action === 'continue') {
                return redirect()->route('missions.create')->with('success', __('missions.create.success-next'));
            }

            return redirect()->route('missions.index')->with('success', __('missions.create.success-next'));

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
        return view('admin.missions.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, Missions $mission)
    {
        return view('admin.missions.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, Missions $mission)
    {
        $user = auth()->user();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, Missions $mission)
    {
        return redirect()->back()
                ->withInput()
                ->with('success', __('missions.delete.confirm'));
    }

    public function updateStatus($locale, Missions $mission, $value)
    {
        $mission->update([
            'status' => $value,
            'status_updated_by' => Auth::id(),
        ]);

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

        return redirect()->back()
                ->withInput()
                ->with('success', __('missions.index.featured.success'));
    }
}
