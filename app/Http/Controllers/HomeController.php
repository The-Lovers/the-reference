<?php

namespace App\Http\Controllers;

use App\Mail\ContactRequestSubmitted;
use App\Models\ContactRequest;
use App\Models\Destination;
use App\Models\Domains;
use App\Models\Missions;
use App\Models\Services;
use App\Models\User;
use App\Notifications\ContactRequestNotification;
use App\Repositories\DomainsRepository;
use App\Repositories\DestinationRepository;
use App\Repositories\MissionsRepository;
use App\Repositories\ServicesRepository;
use App\Repositories\TestimoniesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

    public function contact(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'contactable_alias' => ['nullable', 'string', 'in:service,destination,mission,domain'],
            'contactable_id' => ['nullable', 'integer'],
        ]);

        try {
            $context = $this->resolveContactContext(
                $validated['contactable_alias'] ?? null,
                $validated['contactable_id'] ?? null
            );

            $subject = $context['label'] ?? trim((string) ($validated['subject'] ?? ''));
            $sourceLabel = $context['source_label'] ?? __('index.contain.form.direct-request');

            if ($subject === '') {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['subject' => __('index.contain.form.subject_required')]);
            }

            $contactRequest = ContactRequest::create([
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'subject' => $subject,
                'message' => $validated['message'],
                'source_type' => $context['alias'] ?? 'direct',
                'source_label' => $sourceLabel,
                'contactable_type' => $context['model'] ? get_class($context['model']) : null,
                'contactable_id' => $context['model']?->getKey(),
            ]);

            $payload = [
                'title' => __('index.contain.form.notification_title'),
                'message' => __('index.contain.form.notification_message', [
                    'name' => $contactRequest->full_name,
                    'subject' => $contactRequest->subject,
                ]),
                'subject_label' => $contactRequest->subject,
                'resource_type' => 'contact',
                'source_label' => $contactRequest->source_label,
                'visitor_name' => $contactRequest->full_name,
                'visitor_phone' => $contactRequest->phone,
                'visitor_email' => $contactRequest->email,
            ];

            User::query()->get()->each(function (User $user) use ($payload) {
                $user->notify(new ContactRequestNotification($payload));
            });

            $recipient = config('mail.contact_address');

            if (!empty($recipient)) {
                Mail::to($recipient)->send(new ContactRequestSubmitted($contactRequest));
            } else {
                Log::warning('MAIL_CONTACT_ADDRESS is not configured. Contact request email not sent.', [
                    'contact_request_id' => $contactRequest->id,
                ]);
            }

            return redirect()
                ->to(route('index', ['locale' => app()->getLocale()]) . '#contact-form')
                ->with('success', __('index.contain.form.success'));
        } catch (\Throwable $e) {
            Log::error('Contact request submission failed: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('index.contain.form.error'));
        }
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

    private function resolveContactContext(?string $alias, ?int $id): array
    {
        if (!$alias || !$id) {
            return [
                'alias' => null,
                'label' => null,
                'source_label' => null,
                'model' => null,
            ];
        }

        $map = [
            'service' => Services::class,
            'destination' => Destination::class,
            'mission' => Missions::class,
            'domain' => Domains::class,
        ];

        $modelClass = $map[$alias] ?? null;

        if (!$modelClass) {
            return [
                'alias' => null,
                'label' => null,
                'source_label' => null,
                'model' => null,
            ];
        }

        $model = $modelClass::query()->find($id);

        if (!$model) {
            return [
                'alias' => null,
                'label' => null,
                'source_label' => null,
                'model' => null,
            ];
        }

        $label = $model->title ?? $model->label ?? __('index.contain.form.direct-request');

        return [
            'alias' => $alias,
            'label' => $label,
            'source_label' => ucfirst($alias) . ' - ' . $label,
            'model' => $model,
        ];
    }
}
