<?php

namespace App\Http\Controllers\Dashboard\admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AdminNotificationController extends Controller
{
    function  index()
    {
        $admin = Admin::find(auth()->id());
        return response()->json([
            'notifications' => $admin->notifications
        ]);
    }
    function unreadNotifications()
    {
        $admin = Admin::find(auth()->id());
        return response()->json([
            'unreadNotifications' => $admin->unreadNotifications
        ]);
    }
    function markAllAsRead()
    {
        $admin = Admin::find(auth()->id());
        // $admin->unreadNotifications->markAsRead();
        $admin->unreadNotifications()->where('id', '0a4b06d6-f692-4d93-87ad-718e505ebe56')->update(['read_at' => now()]);
        return response()->json([
            'markAsRead' => 'success'
        ]);
    }
    function markAsReadById($id)
    {
        $admin = Admin::find(auth()->id());
        $admin->unreadNotifications()->where('id', $id)->update(['read_at' => now()]);
        return response()->json([
            'markAsReadById' => 'success'
        ]);
    }
    function deleteAll()
    {
        $admin = Admin::find(auth()->id());
        $admin->notifications()->delete();
        return response()->json([
            'deleteAll' => 'success delete'
        ]);
    }
    function deleteById($id)
    {
        $admin = Admin::find(auth()->id());
        $admin->notifications()->where('id', $id)->delete();
        return response()->json([
            'deleteAll' => 'success delete'
        ]);
    }
}
