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
     *
     * @return FavoriteCurrenciesResource
     */
    public function index()
    {
        return new FavoriteCurrenciesResource(FavoriteCurrency::where('user_id', Auth::id()));
    }

    /**
     * Store a newly created resource in storage.
     *
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
     *
     * @param  \App\FavoriteCurrency  $favoriteCurrency
     * @return FavoriteCurrencyResource
     */
    public function show(FavoriteCurrency $favoriteCurrency)
    {
        return new FavoriteCurrencyResource($favoriteCurrency);
    }

    /**
     * Update the specified resource in storage.
     *
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
     *
     * @param  \App\FavoriteCurrency  $favoriteCurrency
     * @return \Illuminate\Http\Response
     */
    public function destroy(FavoriteCurrency $favoriteCurrency)
    {
        $favoriteCurrency->delete();
    }
}
