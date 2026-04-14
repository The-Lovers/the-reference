<?php

namespace App\Http\Controllers;

use App\Repositories\DomainsRepository;
use App\Repositories\DestinationRepository;
use App\Repositories\MissionsRepository;
use App\Repositories\ServicesRepository;
use App\Repositories\TestimoniesRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $missionRepository;
    protected $domainRepository;
    protected $testimonyRepository;
    protected $serviceRepository;
    protected $destinationRepository;

    public function __construct(
        MissionsRepository $missionRepository,
        DomainsRepository $domainRepository,
        TestimoniesRepository $testimonyRepository,
        ServicesRepository $serviceRepository,
        DestinationRepository $destinationRepository
    ) {
        $this->missionRepository = $missionRepository;
        $this->domainRepository = $domainRepository;
        $this->testimonyRepository = $testimonyRepository;
        $this->serviceRepository = $serviceRepository;
        $this->destinationRepository = $destinationRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = $this->serviceRepository->getAllWithOrder();
        $destinations = $this->destinationRepository->getAllWithOrder();
        $missions = $this->missionRepository->getAllWithOrder();
        $domains = $this->domainRepository->getAllWithOrder();
        $testimonies = $this->testimonyRepository->getAllWithOrder();
        return view('index', compact('services', 'destinations', 'missions', 'domains', 'testimonies'));
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
