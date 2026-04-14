<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domains;
use App\Repositories\DomainsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DomainController extends Controller
{
    protected $domainRepository;

    public function __construct(DomainsRepository $domainRepository)
    {
        $this->domainRepository = $domainRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $domains = $this->domainRepository->getAll();
        return view('admin.domains.index', compact('domains'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lines = file(storage_path('app/icons.txt'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $icons = array_map(function($line) {
            return trim($line, " \t\n\r\",");
        }, $lines);

        shuffle($icons);
        $icons = array_slice($icons, 0, 45);
        return view('admin.domains.create', compact('icons'));
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
            'status' => ['required', 'in:0,1'],
            'is_featured' => ['required', 'in:0,1'],
            'action' => ['required', 'string'],
            'cover'  => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ]);

        try {
            if (!str_starts_with($validated['icon'], 'fa-')) {
                $validated['icon'] = "fa-solid fa-" . $validated['icon'];
            }

            DB::transaction(function () use (&$validated, $request, $user) {
                if ($request->hasFile('cover')) {
                    $file = $request->file('cover');
                    $filename = 'domain_' . time() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/domains'), $filename);
                    $validated['cover'] = 'uploads/domains/' . $filename;
                }

                $domain = new Domains($validated);
                $domain->creator()->associate($user);
                $domain->save();
            });

            $action = $validated['action'];
            if ($action === 'continue') {
                return redirect()->route('domains.create')->with('success', __('domains.create.success-next'));
            }

            return redirect()->route('domains.index')->with('success', __('domains.create.success'));

        } catch (\Throwable $e) {
            Log::error(__('domains.create.error') . ': ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', __('domains.create.error') . ': ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($locale, Domains $domain)
    {
        return view('admin.domains.show', compact('domain'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($locale, Domains $domain)
    {
        $lines = file(storage_path('app/icons.txt'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $icons = array_map(function($line) {
            return trim($line, " \t\n\r\",");
        }, $lines);
        shuffle($icons);
        $icons = array_slice($icons, 0, 45);
        if (!in_array($domain->icon, $icons, true)) {
            array_unshift($icons, $domain->icon);
        }

        return view('admin.domains.edit', compact('domain', 'icons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($locale, Request $request, Domains $domain)
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
            if (!str_starts_with($validated['icon'], 'fa-')) {
                $validated['icon'] = "fa-solid fa-" . $validated['icon'];
            }

            DB::transaction(function () use (&$validated, $request, $user, $domain) {
                if ($request->hasFile('cover')) {
                    if ($domain->cover && file_exists(public_path($domain->cover))) {
                        unlink(public_path($domain->cover));
                    }
                    $file = $request->file('cover');
                    $filename = 'domain_' . time() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/domains'), $filename);
                    $validated['cover'] = 'uploads/domains/' . $filename;
                }

                $domain->fill($validated);
                $domain->updater()->associate($user);
                $domain->save();
            });

            $action = $validated['action'];
            if ($action === 'continue') {
                return redirect()->route('domains.edit', $domain)->with('success', __('domains.update.success-next'));
            }

            return redirect()->route('domains.index')->with('success', __('domains.update.success'));

        } catch (\Throwable $e) {
            Log::error(__('domains.update.error') . ': ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', __('domains.update.error') . ': ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($locale, Domains $domain)
    {
        try {
            DB::transaction(function () use ($domain) {
                if ($domain->cover && file_exists(public_path($domain->cover))) {
                    unlink(public_path($domain->cover));
                }
                $domain->delete();
            });

            return redirect()->route('domains.index')->withInput()->with('success', __('domains.delete.success'));

        } catch (\Throwable $e) {
            Log::error(__('domains.delete.error') . ': ' . $e->getMessage());

            return redirect()->back()->with('error', __('domains.delete.error') . ': ' . $e->getMessage());
        }
    }

    public function updateStatus($locale, Domains $domain, $value)
    {
        $domain->update([
            'status' => $value,
            'status_updated_by' => Auth::id(),
        ]);

        return redirect()->back()
                ->withInput()
                ->with('success', __('domains.index.status.success'));
    }

    public function updateFeatured($locale, Domains $domain, $value)
    {
        $domain->update([
            'is_featured' => $value,
            'featured_updated_by' => Auth::id(),
        ]);

        return redirect()->back()
                ->withInput()
                ->with('success', __('domains.index.featured.success'));
    }
}
