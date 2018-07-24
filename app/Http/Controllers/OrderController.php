<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Resources\OrdersResource;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

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
    public function index(Request $request)
    {
        $orders = Order::where('user_id',$request->user()->id)->get();
        foreach ($orders as &$order) {
            $order->rate_source;
            $order->source_currency;
            $order->destination_currency;
            $order->source_asset;
            $order->destination_asset;
            $order->type;
            $order->user;
            $order->deals;
        }
        return $orders;
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
     *      ),
     *     @SWG\Property(
     *          property="name",
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
            'limit_to' => $request->limit_to,
            'name' => $request->name,
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
            'limit_to' => $request->limit_to,
            'name' => $request->name,

        ]);
        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     **@SWG\Delete(
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

    /**
     * Remove the specified resource from storage.
     **@SWG\Post(
     *   path="/orders/filter",
     *   summary="filter orders",
     *   operationId="filter",
     *   tags={"orders"},
     *  @SWG\Parameter(
     *     name="source_currency_id",
     *     in="path",
     *     description="Source currency ID",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     name="destination_currency_id",
     *     in="path",
     *     description="Source currency ID",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     name="amount",
     *     in="path",
     *     description="Desired amount",
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
     * @return OrdersResource
     */
    public function filter(Request $request)
    {
        if (empty($request->destination_currency_id) && empty($request->source_currency_id)) {
            return new OrdersResource(collect([]));
        }

        $orders = Order::where([
            'destination_currency_id' => $request->destination_currency_id,
            'source_currency_id' => $request->source_currency_id
        ])->get();
        $orders = $orders->reject(function($value, $key) {
           return $value->user_id == Auth::id();
        });

        $entities = collect([]);
        foreach ($orders as $order) {
            $valid = true;
            if ($order->limit_from && $request->amount) {
                $valid &= $order->limit_from <= floatval($request->amount);
            }
            if ($order->limit_to && $request->amount) {
                $valid &= $order->limit_to >= floatval($request->amount);
            }
            if ($valid) {
                $entities->push($order);
            }
        }

        // Sorting params
        $entities = $entities->sortBy(function ($order, $key) {
            switch (Auth::user()->sort) {
                case 'price':
                    return $order->price();
                case 'rank':
                    return $order->user->rank;
            }
        });
        foreach ($entities as &$order) {
            $order->rate_source;
            $order->source_currency;
            $order->destination_currency;
            $order->source_asset;
            $order->destination_asset;
            $order->type;
            $order->user;
            $order->deals;
            $order->favourites;
        }
        return $entities;
    }
}
