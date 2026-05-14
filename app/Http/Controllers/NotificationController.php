<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function markAllRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        $notif = Notification::find($id);
        if ($notif) {
            $notif->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
    public function clearRead()
    {
        Notification::where('is_read', true)->delete();
        return response()->json(['success' => true]);
    }
}
