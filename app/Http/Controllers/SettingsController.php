<?php

namespace App\Http\Controllers;

use App\Http\Resources\SettingsResource;
use App\Settings;
use App\User;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @SWG\Put(
     *   path="/settings",
     *   summary="update user settings",
     *   operationId="update",
     *   tags={"settings"},
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
     *     description="key for param update",
     *     required=true,
     *   @SWG\Schema(
     *      @SWG\Property(
     *          property="key",
     *          type="string"
     *      )
     *     ),
     *     @SWG\Schema(
     *      @SWG\Property(
     *          property="value",
     *          type="string"
     *      )
     *     )
     *   ),
     *
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return SettingsResource
     */
    public function update(Request $request)
    {
        if (in_array($request->key, User::SETTINGS_FILLABLE)){
              $user = $request->user();
              $user->{$request->key} = $request->value;
              $user->save();
            return response()->json(['success' => true, 'data'=> ['user'=>$user]]);
        }
        return response()->json(['success'=> false, 'error'=> 'You don\'t have access for this Action' ]);
    }
}
