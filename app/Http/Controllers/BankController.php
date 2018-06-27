<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Http\Resources\BankResource;
use App\Http\Resources\BanksResource;
use Illuminate\Http\Request;

/**
 * Class BankController
 * @package App\Http\Controllers
 */
class BankController extends Controller
{

    /**
     * Display a listing of the resource.
     **@SWG\Get(
     *   path="/banks",
     *   summary="Get banks",
     *   operationId="index",
     *   tags={"banks"},
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
     * @return BanksResource
     */
    public function index()
    {
        return new BanksResource(Bank::all());
    }

    /**
     * Store a newly created resource in storage.
     *@SWG\Post(
     *   path="/banks",
     *   summary="create bank",
     *   operationId="store",
     *   tags={"banks"},
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
     *     description="bank",
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
     * @return BankResource
     */
    public function store(Request $request)
    {
        $bank = Bank::create(['name' => $request->name]);
        return new BankResource($bank);
    }

    /**
     * Display the specified resource.
     *@SWG\Get(
     *   path="/banks/{id}",
     *   summary="Get bank",
     *   operationId="show",
     *   tags={"banks"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target bank.",
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
    @SWG\Put(
     *   path="/banks/{id}",
     *   summary="Get banks",
     *   operationId="index",
     *   tags={"banks"},
     * *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target bank.",
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
     *     description="bank",
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
     **@SWG\DELETE(
     *   path="/banks/{id}",
     *   summary="delete bank",
     *   operationId="destroy",
     *   tags={"banks"},
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Target banks.",
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
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        $bank->delete();
    }
}
