<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonies;
use App\Repositories\TestimoniesRepository;
use App\Services\AdminActivityNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
    public function store($locale, Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'note' => ['nullable', 'integer', 'between:1,5'],
            'message' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:0,1'],
            'avatar' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'action' => ['required', 'string'],
        ]);

        try {
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = 'testimony_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/testimonies'), $filename);
                $validated['avatar'] = 'uploads/testimonies/' . $filename;
            }

            $testimony = Testimonies::create([
                'name' => $validated['name'],
                'surname' => $validated['surname'],
                'note' => $validated['note'] ?? null,
                'message' => $validated['message'],
                'description' => $validated['description'] ?? null,
                'status' => (bool) $validated['status'],
                'status_updated_by' => Auth::id(),
                'avatar' => $validated['avatar'] ?? null,
            ]);

            app(AdminActivityNotifier::class)->notify(Auth::user(), 'created', 'temoignage', $testimony);

            if ($validated['action'] === 'continue') {
                return redirect()->route('testimonies.edit', $testimony)
                    ->with('success', __('infos.testimony.creation-success'));
            }

            return redirect()->route('testimonies.index')
                ->with('success', __('infos.testimony.creation-success'));
        } catch (\Throwable $e) {
            Log::error(__('infos.testimony.creation-error-log') . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', __('infos.testimony.creation-error'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, Testimonies $testimony)
    {
        return view('admin.testimonies.show', compact('testimony'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, Testimonies $testimony)
    {
        return view('admin.testimonies.edit', compact('testimony'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, Testimonies $testimony)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'note' => ['nullable', 'integer', 'between:1,5'],
            'message' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:0,1'],
            'avatar' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'action' => ['required', 'string'],
        ]);

        try {
            if ($request->hasFile('avatar')) {
                if ($testimony->avatar && file_exists(public_path($testimony->avatar))) {
                    unlink(public_path($testimony->avatar));
                }

                $file = $request->file('avatar');
                $filename = 'testimony_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/testimonies'), $filename);
                $validated['avatar'] = 'uploads/testimonies/' . $filename;
            }

            $testimony->update([
                'name' => $validated['name'],
                'surname' => $validated['surname'],
                'note' => $validated['note'] ?? null,
                'message' => $validated['message'],
                'description' => $validated['description'] ?? null,
                'status' => (bool) $validated['status'],
                'status_updated_by' => Auth::id(),
                'avatar' => $validated['avatar'] ?? $testimony->avatar,
            ]);

            app(AdminActivityNotifier::class)->notify(Auth::user(), 'updated', 'temoignage', $testimony);

            if ($validated['action'] === 'continue') {
                return redirect()->route('testimonies.edit', $testimony)
                    ->with('success', __('infos.testimony.edition-success'));
            }

            return redirect()->route('testimonies.index')
                ->with('success', __('infos.testimony.edition-success'));
        } catch (\Throwable $e) {
            Log::error(__('infos.testimony.edition-error-log') . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', __('infos.testimony.edition-error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, Testimonies $testimony)
    {
        try {
            app(AdminActivityNotifier::class)->notify(Auth::user(), 'deleted', 'temoignage', $testimony);
            if ($testimony->avatar && file_exists(public_path($testimony->avatar))) {
                unlink(public_path($testimony->avatar));
            }
            $testimony->delete();
            return redirect()->route('testimonies.index')
                ->with('success', __('infos.testimony.deletion-success'));
        } catch (\Throwable $e) {
            Log::error(__('infos.testimony.deletion-error-log') . $e->getMessage());
            return redirect()->back()
                ->with('error', __('infos.testimony.deletion-error'));
        }
    }
}
