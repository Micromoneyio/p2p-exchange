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
    @SWG\Get(
     *   path="/rate_sources",
     *   summary="Get rate_sources",
     *   operationId="index",
     *   tags={"rate_sources"},
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
     * @return RateSourcesResource
     */
    public function index()
    {
        return new RateSourcesResource(RateSource::all());
    }

    /**
     * Store a newly created resource in storage.
     *  @SWG\Post(
     *   path="/rate_sources",
     *   summary="create rate_sources",
     *   operationId="store",
     *   tags={"rate_sources"},
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
     *     description="rate_sources",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="name",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="default",
     *          type="string"
     *      )
     *     )
     *   ),
     *     @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
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
     *@SWG\Get(
     *   path="/rate_sources/{id}",
     *   summary="Get rate_sources",
     *   operationId="show",
     *   tags={"rate_sources"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target rate_sources.",
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
     * @param  \App\RateSource  $rateSource
     * @return RateSourceResource
     */
    public function show(RateSource $rateSource)
    {
        return new RateSourceResource($rateSource);
    }

    /**
     * Update the specified resource in storage.
     *   @SWG\Put(
     *   path="/rate_sources/{id}",
     *   summary="update rate_sources",
     *   operationId="update",
     *   tags={"rate_sources"},
     * *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target rate_sources.",
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
     *     description="rate_sources",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="name",
     *          type="string"
     *      ),
     *     @SWG\Property(
     *          property="default",
     *          type="string"
     *      )
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
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
     **@SWG\DELETE(
     *   path="/rate_sources/{id}",
     *   summary="delete rate_sources",
     *   operationId="destroy",
     *   tags={"rate_sources"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target rate_sources.",
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
     * @param  \App\RateSource  $rateSource
     * @return \Illuminate\Http\Response
     */
    public function destroy(RateSource $rateSource)
    {
        return $rateSource->delete();
    }
}
