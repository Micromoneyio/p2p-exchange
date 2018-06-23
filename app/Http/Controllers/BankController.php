<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Http\Resources\BankResource;
use App\Http\Resources\BanksResource;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return BanksResource
     */
    public function index()
    {
        return new BanksResource(Bank::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return BankResource
     */
    public function store(Request $request)
    {
        $bank = Bank::create(['name' => $request->name]);
        return new BankResource($bank);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return BankResource
     */
    public function show(Bank $bank)
    {
        BankResource::withoutWrapping();
        return new BankResource($bank);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bank  $bank
     * @return BankResource
     */
    public function update(Request $request, Bank $bank)
    {
        $bank->update(['name' => $request->bank]);
        return new BankResource($bank);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        $bank->delete();
    }
}
