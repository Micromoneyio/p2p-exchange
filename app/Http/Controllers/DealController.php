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
     *
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
     *
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
     *
     * @param  \App\Deal  $deal
     * @return DealResource
     */
    public function show(Deal $deal)
    {
        return new DealResource($deal);
    }

    /**
     * Update the specified resource in storage.
     *
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
     *
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
