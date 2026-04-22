<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\DomainsRepository;
use App\Repositories\MissionsRepository;
use App\Repositories\ServicesRepository;
use App\Repositories\DestinationRepository;
use App\Repositories\TestimoniesRepository;

class DashboardController extends Controller
{
    protected $domainRepository;
    protected $missionRepository;
    protected $destinationRepository;
    protected $servicesRepository;
    protected $testimoniesRepository;


    public function __construct(DomainsRepository $domainRepository, MissionsRepository $missionRepository,
        DestinationRepository $destinationRepository, ServicesRepository $servicesRepository,TestimoniesRepository $testimoniesRepository
    )
    {
        $this->domainRepository = $domainRepository;
        $this->missionRepository = $missionRepository;
        $this->servicesRepository = $servicesRepository;
        $this->destinationRepository = $destinationRepository;
        $this->testimoniesRepository = $testimoniesRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $date = Carbon::now();
        $missions = $this->missionRepository->getAll();
        $domains = $this->domainRepository->getAll();
        $services = $this->servicesRepository->getAll();
        $destinations = $this->destinationRepository->getAll();
        $testimonies = $this->testimoniesRepository->getAll();
        $quantities = [
            'missions' => $missions->count(),
            'domains' => $domains->count(),
            'services' => $services->count(),
            'destinations' => $destinations->count(),
            'testimonies' => $testimonies->count(),
        ];
        $visitedQuantity = [
            'missions' => $missions->where('visited', true)->count(),
            'domains' => $domains->where('visited', true)->count(),
            'services' => $services->where('visited', true)->count(),
            'destinations' => $destinations->where('visited', true)->count(),
            'testimonies' => $testimonies->where('visited', true)->count(),
        ];
        return view('admin.dashboard', compact('date', 'missions', 'domains', 'services', 'destinations', 'testimonies', 'quantities', 'visitedQuantity'));
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
