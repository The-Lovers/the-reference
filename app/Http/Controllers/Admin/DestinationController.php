<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\DestinationRepository;
use Illuminate\Http\Request;

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
        return view('admin.destinations.create');
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
        return view('admin.destinations.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.destinations.edit');
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
