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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new CurrenciesResource(Currency::all());
    }

    /**
     * Store a newly created resource in storage.
     *
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
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        return new CurrencyResource($currency);
    }

    /**
     * Update the specified resource in storage.
     *
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
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();
    }
}
