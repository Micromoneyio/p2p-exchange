<?php

namespace App\Http\Controllers;

use App\DealHistory;
use App\Http\Resources\DealHistoriesResource;
use App\Http\Resources\DealHistoryResource;
use Illuminate\Http\Request;

class DealHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
    @SWG\Get(
     *   path="/deal_histories",
     *   summary="Get deal_histories",
     *   operationId="index",
     *   tags={"deal_histories"},
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
     * @return DealHistoriesResource
     */
    public function index(Request $request)
    {
        return new DealHistoriesResource(DealHistory::where('deal_id', $request->deal_id));
    }

    /**
     * Store a newly created resource in storage.
     *  @SWG\Post(
     *   path="/deal_histories",
     *   summary="create deal_histories",
     *   operationId="store",
     *   tags={"deal_histories"},
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
     *     description="deal_histories",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="deal_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="deal_stage_id",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="notes",
     *          type="string"
     *      )
     *     )
     *   ),
     *     @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return DealHistoryResource
     */
    public function store(Request $request)
    {
        $dealHistory = DealHistory::create([
            'deal_id' => $request->deal_id,
            'deal_stage_id' => $request->deal_stage_id,
            'notes' => $request->notes
        ]);
        return new DealHistoryResource($dealHistory);
    }

    /**
     * Display the specified resource.
     *@SWG\Get(
     *   path="/deal_histories/{id}",
     *   summary="Get deal_histories",
     *   operationId="show",
     *   tags={"deal_histories"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target deal_histories.",
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
     * @param  \App\DealHistory  $dealHistory
     * @return \Illuminate\Http\Response
     */
    public function show(DealHistory $dealHistory)
    {
        return new DealHistoryResource($dealHistory);
    }

    /**
     * Update the specified resource in storage.
    @SWG\Put(
     *   path="/deal_histories/{id}",
     *   summary="update deal_histories",
     *   operationId="deal_histories",
     *   tags={"deal_histories"},
     * *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target deal_histories.",
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
     *     description="deal_histories",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="deal_stage_id",
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
     * @param  \App\DealHistory  $dealHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DealHistory $dealHistory)
    {
        $dealHistory->update([
            'deal_stage_id' => $request->deal_stage_id,
            'notes' => $request->notes
        ]);
        return new DealHistoryResource($dealHistory);
    }

    /**
     * Remove the specified resource from storage.
     **@SWG\DELETE(
     *   path="/deal_histories/{id}",
     *   summary="delete deal_histories",
     *   operationId="destroy",
     *   tags={"deal_histories"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target deal_histories.",
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
     * @param  \App\DealHistory  $dealHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(DealHistory $dealHistory)
    {
        $dealHistory->delete();
    }
}
