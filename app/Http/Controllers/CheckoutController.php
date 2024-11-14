<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\StoreCheckoutRequest;
use App\Http\Requests\UpdateCheckoutRequest;
use App\Http\Resources\CheckoutResource;
use App\Interfaces\CheckoutRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;

class CheckoutController extends Controller
{
    private CheckoutRepositoryInterface $checkoutRepository;

    public function __construct(CheckoutRepositoryInterface $checkoutRepository)
    {
        $this->checkoutRepository = $checkoutRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->checkoutRepository->findAll();
            return ApiResponseClass::sendResponse($data, 'success get all data Checkout');

        } catch (Exception $e) {

            return ApiResponseClass::sendFail("Checkout Delete Fail : {$e->getMessage()}");

        }
    }

    public function findByIdUser($id): JsonResponse
    {
        try {
            $data = $this->checkoutRepository->findByIdUser($id);
            return ApiResponseClass::sendResponse($data, 'success', 201);

        } catch (Exception $e) {

            return ApiResponseClass::sendFail("Checkout Delete Fail id $$id : {$e->getMessage()}");

        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): JsonResponse
    {
        return ApiResponseClass::sendFail('not implement', 301);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCheckoutRequest $request): JsonResponse
    {
        try {
//            $checkout = [
//                'id_user' => $request->id_user,
//                'total' => $request->total,
//                'payment_method' => $request->payment_method,
//                'payment_price' => $request->payment_price,
//                'delivery_method' => $request->delivery_method,
//                'delivery_price' => $request->delivery_price,
//            ];
//            DB::beginTransaction();
            $data = $this->checkoutRepository->create($request->toArray());
//            DB::commit();
            return ApiResponseClass::sendResponse(new CheckoutResource($data), 'Checkout Create Successful');

        } catch (Exception $ex) {
//            return ApiResponseClass::rollback($ex);
            return ApiResponseClass::sendFail('Checkout Create Fail ' . $ex->getMessage(), 404);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        try {
            $data = $this->checkoutRepository->findId($id);
            return ApiResponseClass::sendResponse(new CheckoutResource($data), 'success', 201);
        } catch (Exception $e) {
            return ApiResponseClass::sendFail('Checkout Delete Fail ' . $e->getMessage(), 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): JsonResponse
    {
        return ApiResponseClass::sendResponse('not implement ' . $id, 404);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCheckoutRequest $request, $id): JsonResponse
    {
        try {
//            $checkout = [
//                'id_user' => $request->id_user,
//                'total' => $request->total,
//                'payment_method' => $request->payment_method,
//                'payment_price' => $request->payment_price,
//                'delivery_method' => $request->delivery_method,
//                'delivery_price' => $request->delivery_price,
//            ];
//            DB::beginTransaction();
            $this->checkoutRepository->update($request->toArray(), $id);
//            DB::commit();
            return ApiResponseClass::sendResponse('Checkout Update Successful', '');

        } catch (Exception $e) {
//            return ApiResponseClass::rollback($e);
            return ApiResponseClass::sendFail('Checkout Update Fail : ' . $e->getMessage());

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->checkoutRepository->delete($id);
            return ApiResponseClass::sendResponse('Checkout Delete Successful', '');
        } catch (Exception $ex) {
            return ApiResponseClass::sendFail('Checkout Delete Fail', $ex->getMessage());
        }
    }
}
