<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function markAsRead($id)
{
    $notification = auth()->user()->notifications()->where('id', $id)->firstOrFail();

    $notification->markAsRead();

    return redirect()->back()->with('success', 'اعلان خوانده شد.');
}
}
