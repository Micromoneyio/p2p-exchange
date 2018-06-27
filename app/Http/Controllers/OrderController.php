<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Resources\OrdersResource;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
    @SWG\Get(
     *   path="/orders",
     *   summary="Get orders",
     *   operationId="index",
     *   tags={"orders"},
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new OrdersResource(Order::all());
    }

    /**
     * Store a newly created resource in storage.
     *  @SWG\Post(
     *   path="/orders",
     *   summary="create orders",
     *   operationId="store",
     *   tags={"orders"},
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
     *     description="orders",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="source_currency_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="destination_currency_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="rate_source_id",
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
     *          property="fix_price",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="source_price_index",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="limit_from",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="limit_to",
     *          type="string"
     *      )
     *     )
     *   ),
     *     @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Order::create([
            'user_id' => Auth::id(),
            'source_currency_id' => $request->source_currency_id,
            'destination_currency_id' => $request->destination_currency_id,
            'rate_source_id' => $request->rate_source_id,
            'source_asset_id' => $request->source_asset_id,
            'destination_asset_id' => $request->destination_asset_id,
            'fix_price' => $request->fix_price,
            'source_price_index' => $request->source_price_index,
            'limit_from' => $request->limit_from,
            'limit_to' => $request->limit_to
        ]);
        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *@SWG\Get(
     *   path="/orders/{id}",
     *   summary="Get orders",
     *   operationId="show",
     *   tags={"orders"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target orders.",
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
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     *   @SWG\Put(
     *   path="/orders/{id}",
     *   summary="update orders",
     *   operationId="update",
     *   tags={"orders"},
     * *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target orders.",
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
     *     description="orders",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="source_currency_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="destination_currency_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="rate_source_id",
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
     *          property="fix_price",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="source_price_index",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="limit_from",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="limit_to",
     *          type="string"
     *      )
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->update([
            'source_currency_id' => $request->source_currency_id,
            'destination_currency_id' => $request->destination_currency_id,
            'rate_source_id' => $request->rate_source_id,
            'source_asset_id' => $request->source_asset_id,
            'destination_asset_id' => $request->destination_asset_id,
            'fix_price' => $request->fix_price,
            'source_price_index' => $request->source_price_index,
            'limit_from' => $request->limit_from,
            'limit_to' => $request->limit_to
        ]);
        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     **@SWG\DELETE(
     *   path="/orders/{id}",
     *   summary="delete orders",
     *   operationId="destroy",
     *   tags={"orders"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target orders.",
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
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
    }
}
