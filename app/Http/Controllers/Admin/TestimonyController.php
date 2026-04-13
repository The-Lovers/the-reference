<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\TestimoniesRepository;
use Illuminate\Http\Request;

class TestimonyController extends Controller
{
    protected $testimoniesRepository;

    public function __construct(TestimoniesRepository $testimoniesRepository)
    {
        $this->testimoniesRepository = $testimoniesRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonies = $this->testimoniesRepository->getAll();
        return view('admin.testimonies.index', compact('testimonies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonies.create');
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
        return view('admin.testimonies.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.testimonies.edit');
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
