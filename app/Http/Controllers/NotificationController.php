<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Http\Resources\NotificationsResource;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return NotificationsResource
     */
    public function index()
    {
        return new NotificationsResource(Auth::user()->notifications);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return NotificationResource
     */
    public function store(Request $request)
    {
        $notification = Notification::create([
            'user_id' => Auth::id(),
            'deal_id' => $request->deal_id,
            'text' => $request->text
        ]);
        return new NotificationResource($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return NotificationResource
     */
    public function show(Notification $notification)
    {
        return new NotificationResource($notification);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        $notification->update([
            'text' => $request->text,
            'viewed' => $request->viewed
        ]);
        return new NotificationResource($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        return $notification->delete();
    }
}
