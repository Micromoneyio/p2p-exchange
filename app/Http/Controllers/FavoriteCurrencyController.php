<?php

namespace App\Http\Controllers;

use App\FavoriteCurrency;
use App\Http\Resources\FavoriteCurrenciesResource;
use App\Http\Resources\FavoriteCurrencyResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteCurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *  @SWG\Get(
     *   path="/favorite_currencies",
     *   summary="Get favorite_currencies",
     *   operationId="index",
     *   tags={"favorite_currencies"},
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
     * @return FavoriteCurrenciesResource
     */
    public function index()
    {
        return new FavoriteCurrenciesResource(FavoriteCurrency::where('user_id', Auth::id()));
    }

    /**
     * Store a newly created resource in storage.
     *  @SWG\Post(
     *   path="/favorite_currencies",
     *   summary="create favorite_currencies",
     *   operationId="store",
     *   tags={"favorite_currencies"},
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
     *     description="favorite_currencies",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="currency_id",
     *          type="string"
     *      )
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return FavoriteCurrencyResource
     */
    public function store(Request $request)
    {
        $favoriteCurrency = FavoriteCurrency::create([
            'user_id' => Auth::id(),
            'currency_id' => $request->currency_id
        ]);
        return new FavoriteCurrencyResource($favoriteCurrency);
    }

    /**
     * Display the specified resource.
     *@SWG\Get(
     *   path="/favorite_currencies/{id}",
     *   summary="Get favorite_currencies",
     *   operationId="show",
     *   tags={"favorite_currencies"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target favorite_currencies.",
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
     * @param  \App\FavoriteCurrency  $favoriteCurrency
     * @return FavoriteCurrencyResource
     */
    public function show(FavoriteCurrency $favoriteCurrency)
    {
        return new FavoriteCurrencyResource($favoriteCurrency);
    }

    /**
     * Update the specified resource in storage.
     *   @SWG\Put(
     *   path="/favorite_currencies/{id}",
     *   summary="update favorite_currencies",
     *   operationId="update",
     *   tags={"favorite_currencies"},
     * *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target favorite_currencies.",
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
     *     description="favorite_currencies",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="currency_id",
     *          type="string"
     *      )
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FavoriteCurrency  $favoriteCurrency
     * @return FavoriteCurrencyResource
     */
    public function update(Request $request, FavoriteCurrency $favoriteCurrency)
    {
        $favoriteCurrency->update([
            'currency_id' => $request->currency_id
        ]);
        return new FavoriteCurrencyResource($favoriteCurrency);
    }

    /**
     * Remove the specified resource from storage.
     **@SWG\DELETE(
     *   path="/favorite_currencies/{id}",
     *   summary="delete favorite_currencies",
     *   operationId="destroy",
     *   tags={"favorite_currencies"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target favorite_currencies.",
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
     * @param  \App\FavoriteCurrency  $favoriteCurrency
     * @return \Illuminate\Http\Response
     */
    public function destroy(FavoriteCurrency $favoriteCurrency)
    {
        $favoriteCurrency->delete();
    }
}
