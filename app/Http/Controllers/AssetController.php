<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Http\Resources\AssetResource;
use App\Http\Resources\AssetsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AssetsResource
     */
    public function index()
    {
        return new AssetsResource(Auth::user()->assets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return AssetResource
     */
    public function store(Request $request)
    {
        $asset = new Asset([
            'user_id' => Auth::id(),
            'asset_type_id' => $request->asset_type_id,
            'currency_id' => $request->currency_id,
            'bank_id' => $request->bank_id,
            'name' => $request->name,
            'address' => $request->address,
            'key' => $request->key,
            'default' => $request->default,
            'notes' => $request->notes
        ]);
        return new AssetResource($asset);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Asset  $asset
     * @return AssetResource
     */
    public function show(Asset $asset)
    {
        return new AssetResource($asset);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asset $asset)
    {
        if ($asset->user_id != Auth::id()) {
            return;
        }
        else {
            $asset->update([
                'asset_type_id' => $request->asset_type_id,
                'currency_id' => $request->currency_id,
                'bank_id' => $request->bank_id,
                'name' => $request->name,
                'address' => $request->address,
                'key' => $request->key,
                'default' => $request->default,
                'notes' => $request->notes
            ]);
            return new AssetResource($asset);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        if ($asset->user_id != Auth::id()) {
            return;
        }
        else {
            return $asset->delete();
        }
    }
}
