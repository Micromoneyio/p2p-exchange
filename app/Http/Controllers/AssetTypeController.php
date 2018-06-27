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
     **@SWG\Get(
     *   path="/asset_types",
     *   summary="Get asset_types",
     *   operationId="index",
     *   tags={"Asset_type"},
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
     * @return AssetTypesResource
     */
    public function index()
    {
        return new AssetTypesResource(AssetType::all());
    }

    /**
     * Store a newly created resource in storage.
     *@SWG\Post(
     *   path="/asset_types",
     *   summary="create asset_type",
     *   operationId="store",
     *   tags={"Asset_type"},
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
     *          property="name",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="crypto",
     *          type="string"
     *      )
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
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
     *@SWG\Get(
     *   path="/asset_types/{id}",
     *   summary="Get asset_type",
     *   operationId="show",
     *   tags={"Asset_type"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target asset_type.",
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
     * @param  \App\AssetType  $assetType
     * @return AssetTypeResource
     */
    public function show(AssetType $assetType)
    {
        return new AssetTypeResource($assetType);
    }

    /**
     * Update the specified resource in storage.
    @SWG\Put(
     *   path="/asset_types/{id}",
     *   summary="Get asset_types",
     *   operationId="index",
     *   tags={"Asset_type"},
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
     *     description="Asset_type",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="name",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="crypto",
     *          type="string"
     *      )
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
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
     **@SWG\DELETE(
     *   path="/asset_types/{id}",
     *   summary="delete asset",
     *   operationId="destroy",
     *   tags={"Asset_type"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target asset_type.",
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
     * @param  \App\AssetType  $assetType
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetType $assetType)
    {
        return $assetType->delete();
    }
}
