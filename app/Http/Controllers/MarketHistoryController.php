<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Http\Resources\MarketHistoriesResource;
use App\MarketHistory;
use App\RateSource;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MarketHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *@SWG\Get(
     *   path="/market_histories",
     *   summary="Get market histories",
     *   operationId="index",
     *   tags={"MarketHistory"},
     *   @SWG\Parameter(
     *     name="currency_id",
     *     in="query",
     *     description="Filter by currency",
     *     required=falese,
     *     type="string"
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
     * @return MarketHistoriesResource
     */
    public function index(Request $request)
    {
        $entities = collect([]);
        if (!empty($request->currency_id)) {
            foreach (RateSource::all() as $rate_source) {
                foreach (Currency::all() as $currency) {
                    $history = MarketHistory::orderBy('created', 'desc')->where([
                        'currency_id' => $request->currency_id,
                        'unit_currency_id' => $currency->id,
                        'rate_source_id' => $rate_source->id
                    ])->first();
                    if ($history != null) {
                        $entities = $entities.push($history);
                    }
                }
            }
        }
        else {
            foreach (RateSource::all() as $rate_source) {
                foreach (Currency::all() as $currency) {
                    foreach (Currency::all() as $unit_currency) {
                        $history = MarketHistory::orderBy('created', 'desc')->where([
                            'currency_id' => $currency->id,
                            'unit_currency_id' => $unit_currency->id,
                            'rate_source_id' => $rate_source->id
                        ])->first();
                        if ($history != null) {
                            $entities = $entities.push($history);
                        }
                    }
                }
            }
        }
        return new MarketHistoriesResource($entities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MarketHistory  $marketHistory
     * @return \Illuminate\Http\Response
     */
    public function show(MarketHistory $marketHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MarketHistory  $marketHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(MarketHistory $marketHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MarketHistory  $marketHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MarketHistory $marketHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MarketHistory  $marketHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(MarketHistory $marketHistory)
    {
        //
    }
}
