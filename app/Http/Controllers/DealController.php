<?php

namespace App\Http\Controllers;

use App\Deal;
use App\DealStage;
use App\Http\Resources\DealResource;
use App\Http\Resources\DealsResource;
use App\Jobs\CryptoCheckJob;
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
        $deals = $user->deals ?? collect();
        foreach ($user->orders as $order) {
            foreach ($order->deals as $deal) {
                $deals->push($deal);
            }
        }
        if(!$deals)
            return response()->json(['code'=>200,'data'=>[]]);
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
//            'user_id' => Auth::id(),
//            'order_id' => $request->order_id,
//            'source_asset_id' => $request->source_asset_id,
//            'destination_asset_id' => $request->destination_asset_id,
//            'source_value' => $request->source_value,
//            'destination_value' => $request->destination_value,
            'user_id' => 11,
            'order_id' => 1,
            'source_asset_id' => 19,
            'destination_asset_id' => 20,
            'source_value' => 123,
            'destination_value' => 312,
        ]);
        $transitCurrency = $deal->getCryptoCurrency();
        $deal->get_address($transitCurrency->symbol);
        $deal->save();

        CryptoCheckJob::dispatch($deal);
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
     *      ),
     *    @SWG\Property(
     *          property="deal_stage_id",
     *          type="string"
     *      ),
     *    @SWG\Property(
     *          property="transit_currency_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="transit_address",
     *          type="string"
     *      ),
     *      @SWG\Property(
     *          property="transit_key",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="transit_hash",
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
                'destination_value' => $request->destination_value,
                'deal_stage_id' => $request->deal_stage_id,
                'transit_currency_id' => $request->transit_currency_id,
                'transit_address' => $request->transit_address,
                'transit_key' => $request->transit_key,
                'transit_hash' => $request->transit_hash
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

    /**
     * Set deal as payed by non crypto owner
     **@SWG\POST(
     *   path="/deals/{id}/pay",
     *   summary="set deal as payed",
     *   operationId="pay",
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
     * @return DealResource
     */
    public function pay(Deal $deal)
    {
        if (Auth::id() != ($deal->order->type() == 'crypto_to_fiat' ? $deal->user_id : $deal->order->user_id)) {
            return false;
        }
        $deal_stage = DealStage::where(['name' => 'Marked as paid'])->first();
        $deal->update(['deal_stage_id' => $deal_stage->id]);
        return new DealResource($deal);
    }

    /**
     * Release deal transaction
     **@SWG\POST(
     *   path="/deals/{id}/release",
     *   summary="release deal transaction",
     *   operationId="release",
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
     * @return DealResource
     */
    public function release(Deal $deal)
    {
        if (Auth::id() != ($deal->order->type() == 'crypto_to_fiat' ? $deal->order->user_id : $deal->user_id)) {
            return false;
        }
        $deal_stage = DealStage::where(['name' => 'Escrow in releasing transaction'])->first();
        $deal->update(['deal_stage_id' => $deal_stage->id]);
        return new DealResource($deal);
    }
}
