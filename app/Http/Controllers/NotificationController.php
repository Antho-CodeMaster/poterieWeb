<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function hideNotification(Request $request)
    {
        $validated = $request->validate([
            'id_notification' => 'required|integer|exists:notifications,id_notification',
        ]);

        // Use first() to get a single notification
        $notification = Notification::where('id_notification', $validated['id_notification'])->first();

        if ($notification) {
            $notification->visible = 0;
            $notification->save();

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'Notification not found'], 404);
    }
}
