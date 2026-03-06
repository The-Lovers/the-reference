<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Missions;
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
        return view('admin.missions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($locale, Request $request)
    {
        //
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
