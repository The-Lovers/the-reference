<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\AdminActivityNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class AdminActivityNotifier
{
    private const ROLE_HIERARCHY = [
        'user' => 1,
        'admin' => 2,
        'super-admin' => 3,
    ];

    public function notify(
        User $actor,
        string $action,
        string $resourceType,
        Model|User|null $subject = null,
        array $options = []
    ): void {
        $recipients = $this->resolveRecipients($actor, (bool) ($options['self_only'] ?? false));

        if ($recipients->isEmpty()) {
            return;
        }

        $subjectLabel = $options['subject_label'] ?? $this->resolveSubjectLabel($subject, $resourceType);

        $payload = [
            'title' => $this->makeTitle($action, $resourceType),
            'message' => $this->makeMessage($actor, $action, $resourceType, $subjectLabel),
            'action' => $action,
            'resource_type' => $resourceType,
            'subject_label' => $subjectLabel,
            'actor_id' => $actor->id,
            'actor_name' => trim($actor->name . ' ' . $actor->surname),
            'actor_role' => $actor->primaryRoleName(),
            'created_at_human' => now()->diffForHumans(),
        ];

        $recipients->each(function (User $recipient) use ($payload) {
            $recipient->notify(new AdminActivityNotification($payload));
        });
    }

    private function resolveRecipients(User $actor, bool $selfOnly): Collection
    {
        if ($selfOnly) {
            return collect([$actor]);
        }

        $eligibleRoles = $this->eligibleRoleNames($actor);

        return User::query()
            ->with('roles')
            ->whereKeyNot($actor->id)
            ->whereHas('roles', fn ($query) => $query->whereIn('name', $eligibleRoles))
            ->get();
    }

    private function eligibleRoleNames(User $actor): array
    {
        $actorLevel = $actor->highestRoleLevel();

        if ($actorLevel === 0) {
            return $actor->roles->pluck('name')->all();
        }

        return collect(self::ROLE_HIERARCHY)
            ->filter(fn (int $level) => $level >= $actorLevel)
            ->keys()
            ->all();
    }

    private function resolveSubjectLabel(Model|User|null $subject, string $resourceType): string
    {
        if ($subject instanceof User) {
            return trim($subject->name . ' ' . $subject->surname) ?: $subject->email;
        }

        if ($subject instanceof Model) {
            foreach (['title', 'label', 'name', 'username', 'email'] as $attribute) {
                $value = $subject->getAttribute($attribute);
                if (!empty($value)) {
                    return (string) $value;
                }
            }

            if ($subject->getAttribute('surname') || $subject->getAttribute('name')) {
                return trim(($subject->getAttribute('name') ?? '') . ' ' . ($subject->getAttribute('surname') ?? ''));
            }
        }

        return ucfirst($resourceType);
    }

    private function makeTitle(string $action, string $resourceType): string
    {
        $actionLabel = match ($action) {
            'created' => 'Creation',
            'updated' => 'Mise a jour',
            'deleted' => 'Suppression',
            'published' => 'Publication',
            'unpublished' => 'Depublication',
            'featured' => 'Mise a la une',
            'unfeatured' => 'Retrait de la une',
            'activated' => 'Activation',
            'deactivated' => 'Desactivation',
            'profile_updated' => 'Mise a jour du profil',
            default => ucfirst($action),
        };

        return $actionLabel . ' - ' . ucfirst($resourceType);
    }

    private function makeMessage(User $actor, string $action, string $resourceType, string $subjectLabel): string
    {
        $actorName = trim($actor->name . ' ' . $actor->surname) ?: $actor->email;

        $verb = match ($action) {
            'created' => 'a cree',
            'updated' => 'a mis a jour',
            'deleted' => 'a supprime',
            'published' => 'a publie',
            'unpublished' => 'a depublie',
            'featured' => 'a mis a la une',
            'unfeatured' => 'a retire de la une',
            'activated' => 'a active',
            'deactivated' => 'a desactive',
            'profile_updated' => 'a mis a jour son profil',
            default => 'a effectue une action sur',
        };

        if ($action === 'profile_updated') {
            return $actorName . ' ' . $verb . '.';
        }

        return $actorName . ' ' . $verb . ' ' . strtolower($resourceType) . ' "' . $subjectLabel . '".';
    }
}
