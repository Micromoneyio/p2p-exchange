<?php

namespace App\Http\Controllers;

use App\Http\Resources\SettingsResource;
use App\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    /**
     * Display the specified resource.
     *@SWG\Get(
     *   path="/settings/{user_id}",
     *   summary="Get user settings",
     *   operationId="show",
     *   tags={"settings"},
     *  @SWG\Parameter(
     *     name="user_id",
     *     in="path",
     *     description="Id of a user to get settings.",
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
     *
     * @param  int $userId
     * @return SettingsResource
     */
    public function show($userId)
    {
        return new SettingsResource(Settings::forUser($userId));
    }

    /**
     * Update the specified resource in storage.
     *
     * @SWG\Put(
     *   path="/settings/{user_id}",
     *   summary="update user settings",
     *   operationId="update",
     *   tags={"settings"},
     * *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target user id.",
     *     required=true,
     *     type="integer"
     *   ),
     *    @SWG\Parameter(
     *     name="token",
     *     in="query",
     *     description="JWT-token",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="local currency id",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="local_currency_id",
     *          type="integer"
     *      )
     *     )
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $userId
     * @return SettingsResource
     */
    public function update(Request $request, $userId)
    {
        $model = Settings::forUser($userId);
        $model->update($request->only(['local_currency_id']));
        return new SettingsResource($model);
    }
}
