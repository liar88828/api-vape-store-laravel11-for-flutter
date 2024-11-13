<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\StoreDeliveryRequest;
use App\Http\Requests\UpdateDeliveryRequest;
use App\Http\Resources\DeliveryResource;
use App\Interfaces\DeliveryRepositoryInterface;

class DeliveryController extends Controller
{

    private DeliveryRepositoryInterface $deliveryRepository;

    public function __construct(DeliveryRepositoryInterface $deliveryRepository)
    {
        $this->deliveryRepository = $deliveryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = $this->deliveryRepository->findAll();
            return ApiResponseClass::sendResponse($data, '');


        } catch (\Exception $exception) {
            return ApiResponseClass::sendFail('Delivery Delete Fail', $exception->getMessage(), 404);

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return ApiResponseClass::sendFail('Delivery api create is not implement', '', 301);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeliveryRequest $request)
    {
        try {

            $data = $this->deliveryRepository->store($request->toArray());
            return ApiResponseClass::sendResponse(new DeliveryResource($data), 'Delivery Create Successful', 201);
        } catch (\Exception $exception) {
            return ApiResponseClass::sendFail('Delivery Create Fail', $exception->getMessage(), 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = $this->deliveryRepository->findById($id);
            return ApiResponseClass::sendResponse(new DeliveryResource($data), "Delivery Detail Successful $id", 200);
        } catch (\Exception $exception) {
            return ApiResponseClass::sendFail("Delivery Detail Fail $id", $exception->getMessage(), 404);

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return ApiResponseClass::sendFail('bank edit not implement', '', 401);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeliveryRequest $request, $id)
    {
        try {
            $this->deliveryRepository->updateId($request->toArray(), $id);
            return ApiResponseClass::sendResponse($request->all(), "Delivery Update Successful $id", 200);
        } catch (\Exception $exception) {
            return ApiResponseClass::sendFail("Delivery Update Fail $id", $exception->getMessage(), 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->deliveryRepository->deleteId($id);
            return ApiResponseClass::sendResponse('', "Delivery Delete Successful $id", 200);
        } catch (\Exception $exception) {
            return ApiResponseClass::sendFail("Delivery Delete Fail $id", $exception->getMessage(), 404);
        }
    }
}
