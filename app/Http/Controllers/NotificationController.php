<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotificationsUser()
    {
        $notifications = Notification::where('user_id', auth()->user()->id)->latest()->get();

        return response()->json($notifications);
    }

    public function getCountUnreadNotificationsUser()
    {
        $notifications = Notification::where('user_id', auth()->user()->id)->where('unread', true)->get();

        return response()->json(count($notifications));
    }

    public function setUnreadNotificationsUser()
    {
        Notification::where('user_id', auth()->user()->id)->update(['unread' => false]);
    }

    public function removeNotification($id)
    {
        Notification::find($id)->delete();
    }
}
