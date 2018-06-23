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
     *
     * @return DealHistoriesResource
     */
    public function index(Request $request)
    {
        return new DealHistoriesResource(DealHistory::where('deal_id', $request->deal_id));
    }

    /**
     * Store a newly created resource in storage.
     *
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
     *
     * @param  \App\DealHistory  $dealHistory
     * @return \Illuminate\Http\Response
     */
    public function show(DealHistory $dealHistory)
    {
        return new DealHistoryResource($dealHistory);
    }

    /**
     * Update the specified resource in storage.
     *
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
     *
     * @param  \App\DealHistory  $dealHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(DealHistory $dealHistory)
    {
        $dealHistory->delete();
    }
}
