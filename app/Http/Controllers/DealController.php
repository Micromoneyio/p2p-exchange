<?php

namespace App\Http\Controllers;

use App\Deal;
use App\Http\Resources\DealResource;
use App\Http\Resources\DealsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     *   @SWG\Get(
     *   path="/deals",
     *   summary="Get deals",
     *   operationId="index",
     *   tags={"deals"},
     *   @SWG\Parameter(
     *     name="token",
     *     in="query",
     *     description="JWT-token",
     *     required=true,
     *      type="string"
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @return DealsResource
     */
    public function index()
    {
        $user = Auth::user();
        $deals = $user->deals;
        foreach ($user->orders as $order) {
            foreach ($order->deals as $deal) {
                $deals->push($deal);
            }
        }
        return new DealsResource($deals);
    }

    /**
     * Store a newly created resource in storage.
     *   @SWG\Post(
     *   path="/deals",
     *   summary="create deal",
     *   operationId="store",
     *   tags={"deals"},
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
     *     description="deal",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="order_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="source_asset_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="destination_asset_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="source_value",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="destination_value",
     *          type="string"
     *      )
     *     )
     *   ),
     *     @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return DealResource
     */
    public function store(Request $request)
    {
        $deal = new Deal([
            'user_id' => Auth::id(),
            'order_id' => $request->order_id,
            'source_asset_id' => $request->source_asset_id,
            'destination_asset_id' => $request->destination_asset_id,
            'source_value' => $request->source_value,
            'destination_value' => $request->destination_value
        ]);
        $deal->get_address('ETH');
        $deal->save();
        return new DealResource($deal);
    }

    /**
     * Display the specified resource.
     *@SWG\Get(
     *   path="/deals/{id}",
     *   summary="Get deal",
     *   operationId="show",
     *   tags={"deals"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target deal.",
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
     * @param  \App\Deal  $deal
     * @return DealResource
     */
    public function show(Deal $deal)
    {
        return new DealResource($deal);
    }

    /**
     * Update the specified resource in storage.

     * *   @SWG\Put(
     *   path="/deals/{id}",
     *   summary="update deal",
     *   operationId="update",
     *   tags={"deals"},
     * *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target deal.",
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
     *     description="deal",
     *     required=true,
     *     @SWG\Property(
     *          property="source_asset_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="destination_asset_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="source_value",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="destination_value",
     *          type="string"
     *      )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Deal  $deal
     * @return DealResource
     */
    public function update(Request $request, Deal $deal)
    {
        if ($deal->user_id != Auth::id()) {
            return;
        }
        else {
            $deal->update([
                'source_asset_id' => $request->source_asset_id,
                'destination_asset_id' => $request->destination_asset_id,
                'source_value' => $request->source_value,
                'destination_value' => $request->destination_value
            ]);
            return new DealResource($deal);
        }
    }

    /**
     * Remove the specified resource from storage.
     **@SWG\DELETE(
     *   path="/deals/{id}",
     *   summary="delete deal",
     *   operationId="destroy",
     *   tags={"deals"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target deal.",
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
     * @param  \App\Deal  $deal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deal $deal)
    {
        if ($deal->user_id != Auth::id()) {
            return;
        }
        else {
            return $deal->delete();
        }
    }
}
