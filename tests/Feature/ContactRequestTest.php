<?php

namespace Tests\Feature;

use App\Mail\ContactRequestSubmitted;
use App\Models\ContactRequest;
use App\Models\User;
use App\Notifications\ContactRequestNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ContactRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_visitor_can_submit_a_contact_request(): void
    {
        Mail::fake();
        Notification::fake();

        config(['mail.contact_address' => 'contact@example.com']);

        $users = collect([
            User::create([
                'name' => 'Admin',
                'surname' => 'One',
                'username' => 'admin.one',
                'email' => 'admin1@example.com',
                'password' => 'password',
            ]),
            User::create([
                'name' => 'Admin',
                'surname' => 'Two',
                'username' => 'admin.two',
                'email' => 'admin2@example.com',
                'password' => 'password',
            ]),
        ]);

        $response = $this->post('/fr/contact', [
            'full_name' => 'Jean Visiteur',
            'phone' => '+237 699001122',
            'email' => 'visiteur@example.com',
            'subject' => 'Besoin de renseignements',
            'message' => 'Bonjour, je souhaite être recontacté pour un accompagnement.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_requests', [
            'full_name' => 'Jean Visiteur',
            'phone' => '+237 699001122',
            'email' => 'visiteur@example.com',
            'subject' => 'Besoin de renseignements',
            'source_type' => 'direct',
        ]);

        $contactRequest = ContactRequest::query()->first();

        Mail::assertSent(ContactRequestSubmitted::class, function (ContactRequestSubmitted $mail) use ($contactRequest) {
            return $mail->contactRequest->is($contactRequest);
        });

        $users->each(function (User $user) {
            Notification::assertSentTo($user, ContactRequestNotification::class);
        });
    }
}
