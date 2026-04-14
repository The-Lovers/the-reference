<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DirectMessage;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index($locale, Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'conversations' => $user->chatConversationSummaries()->all(),
            'users' => User::query()
                ->whereKeyNot($user->id)
                ->orderBy('name')
                ->orderBy('surname')
                ->get(['id', 'name', 'surname', 'email', 'avatar'])
                ->map(fn (User $chatUser) => $this->serializeUser($chatUser))
                ->values()
                ->all(),
            'unread_count' => $user->chatUnreadCount(),
        ]);
    }

    public function show($locale, Request $request, User $user): JsonResponse
    {
        abort_if($request->user()->is($user), 422);

        DirectMessage::query()
            ->where('sender_id', $user->id)
            ->where('recipient_id', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = DirectMessage::query()
            ->where(function ($query) use ($request, $user) {
                $query->where('sender_id', $request->user()->id)
                    ->where('recipient_id', $user->id);
            })
            ->orWhere(function ($query) use ($request, $user) {
                $query->where('sender_id', $user->id)
                    ->where('recipient_id', $request->user()->id);
            })
            ->orderBy('created_at')
            ->get()
            ->map(fn (DirectMessage $message) => $this->serializeMessage($message, $request->user()->id))
            ->all();

        return response()->json([
            'conversation' => [
                'user' => $this->serializeUser($user),
                'messages' => $messages,
                'unread_count' => $request->user()->chatUnreadCount(),
            ],
        ]);
    }

    public function store($locale, Request $request, User $user): JsonResponse
    {
        abort_if($request->user()->is($user), 422);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
        ]);

        $body = trim($validated['body']);

        abort_if($body === '', 422);

        $message = DirectMessage::create([
            'sender_id' => $request->user()->id,
            'recipient_id' => $user->id,
            'body' => $body,
        ]);

        return response()->json([
            'message' => $this->serializeMessage($message->fresh(), $request->user()->id),
            'success' => __('infos.chat.sent-success'),
        ], 201);
    }

    private function serializeUser(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->full_name,
            'email' => $user->email,
            'avatar_url' => $user->avatar_url,
        ];
    }

    private function serializeMessage(DirectMessage $message, int $currentUserId): array
    {
        return [
            'id' => $message->id,
            'body' => $message->body,
            'created_at' => $message->created_at?->diffForHumans(),
            'created_at_iso' => $message->created_at?->toIso8601String(),
            'is_mine' => $message->sender_id === $currentUserId,
            'is_read' => !is_null($message->read_at),
        ];
    }
}
