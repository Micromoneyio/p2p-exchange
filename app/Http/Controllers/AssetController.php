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
     *@SWG\Get(
     *   path="/assets",
     *   summary="Get assets",
     *   operationId="index",
     *   tags={"Asset"},
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
     * @return AssetsResource
     */
    public function index()
    {

        $result = \auth()->user()->assets;
        foreach($result as &$item){
            $item->currency;
            $item->bank;
        }
     return $result;
        dd($result);
        return \auth()->user()->assets;//new AssetsResource(Auth::user()->assets);
    }

    /**
     * Store a newly created resource in storage.
     *  @SWG\Post(
     *   path="/assets",
     *   summary="Get assets",
     *   operationId="index",
     *   tags={"Asset"},
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
     *     description="Asset",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="asset_type_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="currency_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="bank_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="name",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="address",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="key",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="default",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="notes",
     *          type="string"
     *      )
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
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
     **@SWG\Get(
     *   path="/assets/{id}",
     *   summary="Get asset",
     *   operationId="show",
     *   tags={"Asset"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target asset.",
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
     * @param  \App\Asset  $asset
     * @return AssetResource
     */
    public function show(Asset $asset)
    {
        return new AssetResource($asset);
    }

    /**
     * Update the specified resource in storage.
    @SWG\Put(
     *   path="/assets/{id}",
     *   summary="Get assets",
     *   operationId="index",
     *   tags={"Asset"},
     * *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target asset.",
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
     *     description="Asset",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="asset_type_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="currency_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="bank_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="name",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="address",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="key",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="default",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="notes",
     *          type="string"
     *      )
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
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
     **@SWG\DELETE(
     *   path="/assets/{id}",
     *   summary="Get asset",
     *   operationId="destroy",
     *   tags={"Asset"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target asset.",
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
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        if ($asset->user_id != Auth::id()) {
            return;
        }
        else {
            $asset->delete();
            return response('ok',200);
        }
    }
}
