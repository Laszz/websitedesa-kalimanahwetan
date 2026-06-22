<?php

namespace App\Http\Controllers\warga\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notif = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($notif && !$notif->is_read) {
            $notif->update(['is_read' => true]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}