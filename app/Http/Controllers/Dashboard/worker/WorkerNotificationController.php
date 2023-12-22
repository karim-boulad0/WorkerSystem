<?php

namespace App\Http\Controllers\Dashboard\worker;

use App\Http\Controllers\Controller;
use App\Models\Worker;
use Illuminate\Http\Request;

class WorkerNotificationController extends Controller
{
    function  index()
    {
        $worker = Worker::find(auth()->id());
        return response()->json([
            'notifications' => $worker->notifications
        ]);
    }

    function unreadNotifications()
    {
        $worker = Worker::find(auth()->id());
        return response()->json([
            'unreadNotifications' => $worker->unreadNotifications
        ]);
    }
    function markAllAsRead()
    {
        $worker = Worker::find(auth()->id());
        // $worker->unreadNotifications->markAsRead();
        $worker->unreadNotifications()->where('id','0a4b06d6-f692-4d93-87ad-718e505ebe56')->update(['read_at' => now()]);
        return response()->json([
            'markAsRead' => 'success'
        ]);
    }
    function markAsReadById($id)
    {
        $worker = Worker::find(auth()->id());
        $worker->unreadNotifications()->where('id',$id)->update(['read_at' => now()]);
        return response()->json([
            'markAsReadById' => 'success'
        ]);
    }
    function deleteAll()
    {
        $worker = Worker::find(auth()->id());
        $worker->notifications()->delete();
        return response()->json([
            'deleteAll' => 'success delete'
        ]);
    }
    function deleteById($id)
    {
        $worker = Worker::find(auth()->id());
        $worker->notifications()->where('id',$id)->delete();
        return response()->json([
            'deleteAll' => 'success delete'
        ]);
    }

}
