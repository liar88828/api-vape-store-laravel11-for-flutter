<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Resources\ProductResource;
use App\Http\Resources\TrolleyResource;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\TrolleyRepositoryInterface;
use App\Models\Trolley;
use App\Http\Requests\StoreTrolleyRequest;
use App\Http\Requests\UpdateTrolleyRequest;
use Illuminate\Support\Facades\DB;

class TrolleyController extends Controller
{

    private TrolleyRepositoryInterface $trolleyRepository;

    public function __construct(TrolleyRepositoryInterface $trolleyRepository)
    {
        $this->trolleyRepository = $trolleyRepository;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = $this->trolleyRepository->findAll();
            return ApiResponseClass::sendResponse(TrolleyResource::collection($data), '', 200);

        } catch (\Exception $e) {
            return ApiResponseClass::sendResponse('Trolley Delete Fail', '', 404);
        }
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrolleyRequest $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $response = $this->trolleyRepository->findId($id);
            return ApiResponseClass::sendResponse(new TrolleyResource($response), '', 200);
        } catch (\Exception $ex) {
            return ApiResponseClass::sendResponse("The Data Trolley is not found $id", '', 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trolley $trolley)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrolleyRequest $request, $id)
    {

        try {
            $trolley = [
                'qty' => $request->qty,
                'id_checkout' => $request->id_checkout ?? null,
                'id_product' => $request->id_product,
                'id_user' => $request->id_user,
            ];
//print_r($trolley);
            DB::beginTransaction();
            $this->trolleyRepository->update($trolley, $id);

            DB::commit();
            return ApiResponseClass::sendResponse('Trolley Update Successful', '', 201);

        } catch (\Exception $ex) {
//            DB::disconnect();

//            return ApiResponseClass::rollback($ex);
            return ApiResponseClass::sendResponse('Trolley Update Fail', $ex, 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $response = $this->trolleyRepository->delete($id);
            if ($response) {
                return ApiResponseClass::sendResponse('Trolley Delete Successful', '', 204);
            } else {
                return ApiResponseClass::sendResponse('The Data Trolley is not found', '', 404);
            }

        } catch (\Exception $ex) {
            return ApiResponseClass::sendResponse('Trolley Delete Fail', '', 404);
        }
    }
}
