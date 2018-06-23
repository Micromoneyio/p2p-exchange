<?php

namespace App\Http\Controllers;

use App\Http\Resources\RateSourceResource;
use App\Http\Resources\RateSourcesResource;
use App\RateSource;
use Illuminate\Http\Request;

class RateSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return RateSourcesResource
     */
    public function index()
    {
        RateSourceResource::withoutWrapping();
        return new RateSourcesResource(RateSource::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RateSourceResource
     */
    public function store(Request $request)
    {
        $rateSource = RateSource::create([
            'name'    => $request->name,
            'default' => $request->default
        ]);
        return new RateSourceResource($rateSource);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RateSource  $rateSource
     * @return RateSourceResource
     */
    public function show(RateSource $rateSource)
    {
        RateSourceResource::withoutWrapping();
        return new RateSourceResource($rateSource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RateSource  $rateSource
     * @return RateSourceResource
     */
    public function update(Request $request, RateSource $rateSource)
    {
        $rateSource->update([
            'name'    => $request->name,
            'default' => $request->default
        ]);
        return new RateSourceResource($rateSource);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RateSource  $rateSource
     * @return \Illuminate\Http\Response
     */
    public function destroy(RateSource $rateSource)
    {
        return $rateSource->delete();
    }
}
