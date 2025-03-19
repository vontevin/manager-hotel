<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $notifications = Notification::with('user')
            ->latest()
            ->take(5) // Adjust the limit as needed
            ->get();

        return response()->json($notifications);
    }

}
