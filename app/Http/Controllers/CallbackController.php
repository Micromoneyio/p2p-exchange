<?php

namespace App\Http\Controllers;

use App\Callback;
use App\Http\Resources\CallbacksResource;
use App\Http\Resources\CallbackResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CallbackController extends Controller
{
    /**
     * Display a listing of the resource.
    @SWG\Get(
     *   path="/callbacks",
     *   summary="Get callbacks",
     *   operationId="index",
     *   tags={"callbacks"},
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
     * @return CallbacksResource
     */
    public function index()
    {
        return new CallbacksResource(Auth::user()->callbacks);
    }

    /**
     * Store a newly created resource in storage.
     *  @SWG\Post(
     *   path="/callbacks",
     *   summary="create callback",
     *   operationId="store",
     *   tags={"callbacks"},
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
     *     description="callback",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="event",
     *          type="string",
     *          enum="['deal.create', 'deal.update']"
     *      ),
     *     @SWG\Property(
     *          property="url",
     *          type="string"
     *      )
     *     )
     *   ),
     *     @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return CallbackResource
     */
    public function store(Request $request)
    {
        $callback = Callback::create([
            'user_id' => Auth::id(),
            'event' => $request->event,
            'url' => $request->url
        ]);
        return new CallbackResource($callback);
    }

    /**
     * Display the specified resource.
     *@SWG\Get(
     *   path="/callbacks/{id}",
     *   summary="Get callback",
     *   operationId="show",
     *   tags={"callbacks"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target callback.",
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
     * @param  \App\Callback  $callback
     * @return \Illuminate\Http\Response
     */
    public function show(Callback $callback)
    {
        return new CallbackResource($callback);
    }

    /**
     * Update the specified resource in storage.
     *   @SWG\Put(
     *   path="/callbacks/{id}",
     *   summary="update callback",
     *   operationId="update",
     *   tags={"callbacks"},
     * *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target callback.",
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
     *     description="callback",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="event",
     *          type="string",
     *          enum="['deal.create', 'deal.update']"
     *      ),
     *     @SWG\Property(
     *          property="url",
     *          type="string"
     *      )
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Callback  $callback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Callback $callback)
    {
        $callback->update([
            'url'   => $request->url,
            'event' => $request->event
        ]);
        return new CallbackResource($callback);
    }

    /**
     * Remove the specified resource from storage.
     **@SWG\DELETE(
     *   path="/callbacks/{id}",
     *   summary="delete callback",
     *   operationId="destroy",
     *   tags={"callbacks"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target callback.",
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
     * @param  \App\Callback  $callback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Callback $callback)
    {
        if (Auth::id() == $callback->user_id) {
            $callback->delete();
        }
    }
}
