<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use App\Models\Destination;
use App\Models\Domains;
use App\Models\Missions;
use App\Models\Services;
use App\Models\Testimonies;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $date = Carbon::now();
        $resourceMap = [
            'missions' => [
                'model' => Missions::class,
                'label_field' => 'title',
                'collection' => Missions::query()->orderBy('title')->get(),
            ],
            'domains' => [
                'model' => Domains::class,
                'label_field' => 'title',
                'collection' => Domains::query()->orderBy('title')->get(),
            ],
            'services' => [
                'model' => Services::class,
                'label_field' => 'title',
                'collection' => Services::query()->orderBy('title')->get(),
            ],
            'destinations' => [
                'model' => Destination::class,
                'label_field' => 'label',
                'collection' => Destination::query()->orderBy('label')->get(),
            ],
        ];

        // Regroupe l'interet reel a partir des demandes de contact liees aux contenus.
        $interestGroups = ContactRequest::query()
            ->selectRaw('contactable_type, contactable_id, COUNT(*) as interest_count')
            ->whereNotNull('contactable_type')
            ->whereNotNull('contactable_id')
            ->groupBy('contactable_type', 'contactable_id')
            ->get()
            ->groupBy('contactable_type');

        $summaryCards = [];
        $chartSeries = [];
        $mostSolicited = collect();

        foreach ($resourceMap as $key => $config) {
            /** @var \Illuminate\Support\Collection $resources */
            $resources = $config['collection'];
            $interestRows = collect($interestGroups->get($config['model'], []));
            $interestById = $interestRows
                ->mapWithKeys(fn ($row) => [(int) $row->contactable_id => (int) $row->interest_count]);

            $summaryCards[$key] = [
                'total' => $resources->count(),
                'interested' => $interestById->count(),
                'ratio' => $resources->count() > 0
                    ? (int) round(($interestById->count() / $resources->count()) * 100)
                    : 0,
            ];

            $chartItems = $resources
                ->map(function ($resource) use ($interestById, $config) {
                    $label = (string) data_get($resource, $config['label_field'], __('dashboard.overview.unknown'));

                    return [
                        'id' => $resource->id,
                        'label' => Str::limit($label, 28),
                        'full_label' => $label,
                        'value' => (int) ($interestById[$resource->id] ?? 0),
                    ];
                })
                ->sortByDesc('value')
                ->values();

            $chartSeries[$key] = [
                'labels' => $chartItems->take(6)->pluck('label')->values(),
                'values' => $chartItems->take(6)->pluck('value')->values(),
            ];

            $mostSolicited = $mostSolicited->merge(
                $chartItems
                    ->filter(fn ($item) => $item['value'] > 0)
                    ->take(10)
                    ->map(fn ($item) => [
                        'type' => $key,
                        'label' => $item['full_label'],
                        'count' => $item['value'],
                    ])
            );
        }

        $bestTestimonies = Testimonies::query()
            ->where('status', true)
            ->whereNotNull('note')
            ->orderByDesc('note')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $worstTestimonies = Testimonies::query()
            ->where('status', true)
            ->whereNotNull('note')
            ->orderBy('note')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $mostSolicited = $mostSolicited
            ->sortByDesc('count')
            ->take(8)
            ->values();

        $userActivity = collect();
        $isSuperAdmin = (bool) auth()->user()?->hasRole('super-admin');

        if ($isSuperAdmin) {
            $userActivity = User::query()
                ->with('roles')
                ->withCount([
                    'missionsCreated',
                    'domainsCreated',
                    'servicesCreated',
                    'destinationsCreated',
                ])
                ->get()
                ->map(function (User $user) {
                    $total = (int) (
                        $user->missions_created_count
                        + $user->domains_created_count
                        + $user->services_created_count
                        + $user->destinations_created_count
                    );

                    return [
                        'name' => $user->full_name ?: $user->email,
                        'role' => $user->primary_role_label,
                        'total' => $total,
                        'missions' => (int) $user->missions_created_count,
                        'domains' => (int) $user->domains_created_count,
                        'services' => (int) $user->services_created_count,
                        'destinations' => (int) $user->destinations_created_count,
                    ];
                })
                ->filter(fn ($user) => $user['total'] > 0)
                ->sortByDesc('total')
                ->values();

            $activityTotal = max(1, (int) $userActivity->sum('total'));
            $userActivity = $userActivity
                ->map(function (array $user) use ($activityTotal) {
                    $user['percentage'] = (int) round(($user['total'] / $activityTotal) * 100);

                    return $user;
                })
                ->values();
        }

        return view('admin.dashboard', [
            'date' => $date,
            'summaryCards' => $summaryCards,
            'chartSeries' => $chartSeries,
            'bestTestimonies' => $bestTestimonies,
            'worstTestimonies' => $worstTestimonies,
            'mostSolicited' => $mostSolicited,
            'userActivity' => $userActivity,
            'isSuperAdmin' => $isSuperAdmin,
        ]);
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
