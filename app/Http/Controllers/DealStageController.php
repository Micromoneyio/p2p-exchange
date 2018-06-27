<?php

namespace App\Http\Controllers;

use App\DealStage;
use App\Http\Resources\DealStageResource;
use App\Http\Resources\DealStagesResource;
use Illuminate\Http\Request;

class DealStageController extends Controller
{
    /**
     * Display a listing of the resource.
    @SWG\Get(
     *   path="/deal_stages",
     *   summary="Get deal_stages",
     *   operationId="index",
     *   tags={"deal_stages"},
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
     * @return DealStagesResource
     */
    public function index()
    {
        return new DealStagesResource(DealStage::all());
    }

    /**
     * Store a newly created resource in storage.
     *  @SWG\Post(
     *   path="/deal_stages",
     *   summary="create deal_stages",
     *   operationId="store",
     *   tags={"deal_stages"},
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
     *      )
     *     )
     *   ),
     *     @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return DealStageResource
     */
    public function store(Request $request)
    {
        $dealStage = DealStage::create([
            'name' => $request->name
        ]);
        return new DealStageResource($dealStage);
    }

    /**
     * Display the specified resource.
     *@SWG\Get(
     *   path="/deal_stages/{id}",
     *   summary="Get deal_stages",
     *   operationId="show",
     *   tags={"deal_stages"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target deal_stages.",
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
     * @param  \App\DealStage  $dealStage
     * @return DealStageResource
     */
    public function show(DealStage $dealStage)
    {
        return new DealStageResource($dealStage);
    }

    /**
     * Update the specified resource in storage.
     *   @SWG\Put(
     *   path="/deal_stages/{id}",
     *   summary="update deal_stages",
     *   operationId="update",
     *   tags={"deal_stages"},
     * *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target deal_stages.",
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
     *     description="deal_stages",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="name",
     *          type="string"
     *      )
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DealStage  $dealStage
     * @return DealStageResource
     */
    public function update(Request $request, DealStage $dealStage)
    {
        $dealStage->update([
            'name' => $request->name
        ]);
        return new DealStageResource($dealStage);
    }

    /**
     * Remove the specified resource from storage.
     **@SWG\DELETE(
     *   path="/deal_stages/{id}",
     *   summary="delete deal_stages",
     *   operationId="destroy",
     *   tags={"deal_stages"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target deal_stages.",
     *     required=true,
     *     type="integer"
     *   ),
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
     * @param  \App\DealStage  $dealStage
     * @return \Illuminate\Http\Response
     */
    public function destroy(DealStage $dealStage)
    {
        return $dealStage->delete();
    }
}
