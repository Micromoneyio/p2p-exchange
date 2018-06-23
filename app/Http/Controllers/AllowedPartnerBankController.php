<?php

namespace App\Http\Controllers;

use App\AllowedPartnerBank;
use App\Http\Resources\AllowedPartnerBankResource;
use App\Http\Resources\AllowedPartnerBanksResource;
use Illuminate\Http\Request;

class AllowedPartnerBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AllowedPartnerBanksResource
     */
    public function index(Request $request)
    {
        return new AllowedPartnerBanksResource(AllowedPartnerBank::where('asset_id', $request->asset_id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return AllowedPartnerBankResource
     */
    public function store(Request $request)
    {
        $allowedPartnerBank = AllowedPartnerBank::create([
            'asset_id' => $request->asset_id,
            'bank_id' => $request->bank_id,
            'allow_income' => $request->allow_income,
            'allow_outgoing' => $request->allow_outgoing
        ]);
        return new AllowedPartnerBankResource($allowedPartnerBank);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AllowedPartnerBank  $allowedPartnerBank
     * @return AllowedPartnerBankResource
     */
    public function show(AllowedPartnerBank $allowedPartnerBank)
    {
        return new AllowedPartnerBankResource($allowedPartnerBank);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AllowedPartnerBank  $allowedPartnerBank
     * @return AllowedPartnerBankResource
     */
    public function update(Request $request, AllowedPartnerBank $allowedPartnerBank)
    {
        $allowedPartnerBank->update([
            'bank_id' => $request->bank_id,
            'allow_income' => $request->allow_income,
            'allow_outgoing' => $request->allow_outgoing
        ]);
        return new AllowedPartnerBankResource($allowedPartnerBank);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AllowedPartnerBank  $allowedPartnerBank
     * @return \Illuminate\Http\Response
     */
    public function destroy(AllowedPartnerBank $allowedPartnerBank)
    {
        $allowedPartnerBank->delete();
    }
}
