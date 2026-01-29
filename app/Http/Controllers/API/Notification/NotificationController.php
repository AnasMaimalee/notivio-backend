<?php

namespace App\Http\Controllers\API\Notification;


class NotificationController extends Controller
{
    public function index()
    {
        return auth()->user()
            ->notifications()
            ->latest()
            ->get();
    }

    public function unread()
    {
        return auth()->user()
            ->unreadNotifications;
    }

    public function markAsRead($id)
    {
        auth()->user()
            ->notifications()
            ->findOrFail($id)
            ->markAsRead();

        return response()->json(['status' => 'ok']);
    }
}

