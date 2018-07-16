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
     *    @SWG\Get(
     *   path="/notifications",
     *   summary="Get notifications",
     *   operationId="index",
     *   tags={"notifications"},
     *   @SWG\Parameter(
     *     name="token",
     *     in="query",
     *     description="JWT-token",
     *     required=true,
    type="string"
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @return NotificationsResource
     */
    public function index()
    {
        return new NotificationsResource(Auth::user()->notifications);
    }

    /**
     * Store a newly created resource in storage.
     *  @SWG\Post(
     *   path="/notifications",
     *   summary="create notifications",
     *   operationId="store",
     *   tags={"notifications"},
     *     @SWG\Parameter(
     *     name="token",
     *     in="query",
     *     description="JWT-token",
     *     required=true,
     *       type="string"
     *      ),
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="notifications",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="deal_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="text",
     *          type="string"
     *      )
     *     )
     *   ),
     *     @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return NotificationResource
     */
    public function store(Request $request)
    {
        $notification = Notification::create([
            'user_id' => Auth::id(),
            'deal_id' => $request->deal_id,
            'notes' => $request->text
        ]);
        return new NotificationResource($notification);
    }

    /**
     * Display the specified resource.
     *@SWG\Get(
     *   path="/notifications/{id}",
     *   summary="Get notifications",
     *   operationId="show",
     *   tags={"notifications"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target notifications.",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     in="query",
     *     description="JWT-token",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param  \App\Notification  $notification
     * @return NotificationResource
     */
    public function show(Notification $notification)
    {
        return new NotificationResource($notification);
    }

    /**
     * Update the specified resource in storage.
     *   @SWG\Put(
     *   path="/notifications/{id}",
     *   summary="update notifications",
     *   operationId="update",
     *   tags={"notifications"},
     * *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target notifications.",
     *     required=true,
     *     type="integer"
     *   ),
     *     @SWG\Parameter(
     *     name="token",
     *     in="query",
     *     description="JWT-token",
     *     required=true,
    type="string"
     *      ),
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="notifications",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="text",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="viewed",
     *          type="string"
     *      )
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
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
     **@SWG\DELETE(
     *   path="/notifications/{id}",
     *   summary="delete notifications",
     *   operationId="destroy",
     *   tags={"notifications"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target notifications.",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     name="token",
     *     in="query",
     *     description="JWT-token",
     *     required=true,
    type="string"
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        return $notification->delete();
    }
}
