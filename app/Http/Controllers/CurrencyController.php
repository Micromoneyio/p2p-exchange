<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Http\Resources\CurrenciesResource;
use App\Http\Resources\CurrencyResource;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
    @SWG\Get(
     *   path="/currencies",
     *   summary="Get currencies",
     *   operationId="index",
     *   tags={"currencies"},
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
        return new CurrenciesResource(Currency::all());
    }

    /**
     * Store a newly created resource in storage.
     *  @SWG\Post(
     *   path="/currencies",
     *   summary="create currency",
     *   operationId="store",
     *   tags={"currencies"},
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
     *     description="currency",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="name",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="symbol",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="crypto",
     *          type="string"
     *      )
     *     )
     *   ),
     *     @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return CurrencyResource
     */
    public function store(Request $request)
    {
        $currency = Currency::create([
            'name' => $request->name,
            'symbol' => $request->symbol,
            'crypto' => $request->crypto
        ]);
        return new CurrencyResource($currency);
    }

    /**
     * Display the specified resource.
     *@SWG\Get(
     *   path="/currencies/{id}",
     *   summary="Get currency",
     *   operationId="show",
     *   tags={"currencies"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target currency.",
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
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        return new CurrencyResource($currency);
    }

    /**
     * Update the specified resource in storage.
     *   @SWG\Put(
     *   path="/currency/{id}",
     *   summary="update currency",
     *   operationId="update",
     *   tags={"currencies"},
     * *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target currency.",
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
     *     description="currency",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="name",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="symbol",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="crypto",
     *          type="string"
     *      ),
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        $currency->update([
            'name'   => $request->name,
            'symbol' => $request->symbol,
            'crypto' => $request->crypto
        ]);
        return new CurrencyResource($currency);
    }

    /**
     * Remove the specified resource from storage.
     **@SWG\DELETE(
     *   path="/currencies/{id}",
     *   summary="delete currency",
     *   operationId="destroy",
     *   tags={"currencies"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target currency.",
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
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();
    }
}
