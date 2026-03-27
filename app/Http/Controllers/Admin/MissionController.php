<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Missions;
use App\Models\User;
use App\Repositories\MissionsRepository;
use Illuminate\Http\Request;

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
        $user = auth()->user();
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'status' => ['required'],
            'is_featured' => ['required'],
            'image' => ['required|image|mimes:jpeg,png,jpg,gif|max:2048'],
            'icon' => ['required'],
        ]);
        // Upload image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'mission_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/missions'), $filename);
            $validated['image'] = 'uploads/missions/' . $filename;
        }
        // Création via relation (encore plus propre)
        $mission = new Missions($validated);
        $mission->creator()->associate($user);
        $mission->save();

        // Gestion des boutons
        $action = $request->input('action');

        if ($action === 'continue') {
            return redirect()
                ->route('missions.create') // ou la route que tu veux
                ->with('success', 'Mission enregistrée, continuez...');
        }

        // bouton "Save"
        return redirect()
            ->route('missions.index')
            ->with('success', 'Mission enregistrée avec succès');

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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, Missions $mission)
    {
        //
    }
}
