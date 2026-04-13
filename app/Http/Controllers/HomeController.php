<?php

namespace App\Http\Controllers;

use App\Repositories\DomainsRepository;
use App\Repositories\MissionsRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $missionRepository;
    protected $domainRepository;

    public function __construct(
        MissionsRepository $missionRepository, DomainsRepository $domainRepository
    ) {
        $this->missionRepository = $missionRepository;
        $this->domainRepository = $domainRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $missions = $this->missionRepository->getAllWithOrder();
        $domains = $this->domainRepository->getAllWithOrder();
        return view('index', compact('missions', 'domains'));
    }

    public function error_404()
    {
        return view('layouts.not_found');
    }
    public function mail()
    {
        return view('mail.user_create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
