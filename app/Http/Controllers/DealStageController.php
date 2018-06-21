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
     *
     * @return DealStagesResource
     */
    public function index()
    {
        return new DealStagesResource(DealStage::all());
    }

    /**
     * Store a newly created resource in storage.
     *
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
     *
     * @param  \App\DealStage  $dealStage
     * @return DealStageResource
     */
    public function show(DealStage $dealStage)
    {
        return new DealStageResource($dealStage);
    }

    /**
     * Update the specified resource in storage.
     *
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
     *
     * @param  \App\DealStage  $dealStage
     * @return \Illuminate\Http\Response
     */
    public function destroy(DealStage $dealStage)
    {
        return $dealStage->delete();
    }
}
