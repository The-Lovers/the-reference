<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function markAsRead($locale, DatabaseNotification $notification)
    {
        abort_unless($notification->notifiable_id === auth()->id(), 403);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return response()->json([
            'status' => 'ok',
        ]);
    }

    public function markAllAsRead($locale, Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return response()->json([
            'status' => 'ok',
        ]);
    }
}
