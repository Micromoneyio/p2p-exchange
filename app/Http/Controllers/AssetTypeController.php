<?php

namespace App\Http\Controllers;

use App\AssetType;
use App\Http\Resources\AssetTypeResource;
use App\Http\Resources\AssetTypesResource;
use Illuminate\Http\Request;

class AssetTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AssetTypesResource
     */
    public function index()
    {
        return new AssetTypesResource(AssetType::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return AssetTypeResource
     */
    public function store(Request $request)
    {
        $assetType = AssetType::create([
            'name' => $request->name,
            'crypto' => $request->crypto
        ]);
        return new AssetTypeResource($assetType);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AssetType  $assetType
     * @return AssetTypeResource
     */
    public function show(AssetType $assetType)
    {
        return new AssetTypeResource($assetType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AssetType  $assetType
     * @return AssetTypeResource
     */
    public function update(Request $request, AssetType $assetType)
    {
        $assetType->update([
            'name' => $request->name,
            'crypto' => $request->crypto
        ]);
        return new AssetTypeResource($assetType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AssetType  $assetType
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetType $assetType)
    {
        return $assetType->delete();
    }
}
