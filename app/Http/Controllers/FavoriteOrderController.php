<?php

namespace App\Http\Controllers;

use App\FavoriteOrder;
use App\Http\Resources\FavoriteOrderResource;
use App\Http\Resources\FavoriteOrdersResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return FavoriteOrdersResource
     */
    public function index()
    {
        return new FavoriteOrdersResource(FavoriteOrder::where('user_id', Auth::id()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return FavoriteOrderResource
     */
    public function store(Request $request)
    {
        $favoriteOrder = FavoriteOrder::create([
            'user_id' => Auth::id(),
            'order_id' => $request->order_id
        ]);
        return new FavoriteOrderResource($favoriteOrder);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FavoriteOrder  $favoriteOrder
     * @return FavoriteOrderResource
     */
    public function show(FavoriteOrder $favoriteOrder)
    {
        return new FavoriteOrderResource($favoriteOrder);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FavoriteOrder  $favoriteOrder
     * @return FavoriteOrderResource
     */
    public function update(Request $request, FavoriteOrder $favoriteOrder)
    {
        $favoriteOrder->update([
            'order_id' => $request->order_id
        ]);
        return new FavoriteOrderResource($favoriteOrder);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FavoriteOrder  $favoriteOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(FavoriteOrder $favoriteOrder)
    {
        $favoriteOrder->delete();
    }
}
