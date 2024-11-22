<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\StoreDeliveryRequest;
use App\Http\Requests\UpdateDeliveryRequest;
use App\Http\Resources\DeliveryResource;
use App\Interfaces\DeliveryRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;

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
    public function index(): JsonResponse
    {
        try {
            $data = $this->deliveryRepository->findAll();
            return ApiResponseClass::sendResponse($data, 'success get all data delivery');


        } catch (Exception $exception) {
            return ApiResponseClass::sendFail('Delivery Delete Fail', $exception->getMessage());

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): JsonResponse
    {
        return ApiResponseClass::notImplement();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeliveryRequest $request): JsonResponse
    {
        try {

            $data = $this->deliveryRepository->store($request->toArray());
            return ApiResponseClass::sendResponse(new DeliveryResource($data), 'Delivery Create Successful');
        } catch (Exception $exception) {
            return ApiResponseClass::sendFail('Delivery Create Fail', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        try {
            $data = $this->deliveryRepository->findById($id);
            return ApiResponseClass::sendResponse(new DeliveryResource($data), "Delivery Detail Successful $id", 201);
        } catch (Exception $exception) {
            return ApiResponseClass::sendFail("Delivery Detail Fail $id " . $exception->getMessage());

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(): JsonResponse
    {
        return ApiResponseClass::notImplement();

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeliveryRequest $request, $id): JsonResponse
    {
        try {
            $this->deliveryRepository->updateId($request->toArray(), $id);
            return ApiResponseClass::sendResponse($request->all(), "Delivery Update Successful $id");
        } catch (Exception $exception) {
            return ApiResponseClass::sendFail("Delivery Update Fail $id " . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->deliveryRepository->deleteId($id);
            return ApiResponseClass::sendResponse('', "Delivery Delete Successful $id");
        } catch (Exception $exception) {
            return ApiResponseClass::sendFail("Delivery Delete Fail $id" . $exception->getMessage());
        }
    }
}
