<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\StoreCheckoutRequest;
use App\Http\Requests\UpdateCheckoutRequest;
use App\Http\Resources\CheckoutResource;
use App\Interfaces\CheckoutRepositoryInterface;
use App\Models\Checkout;
use Exception;

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
    public function index()
    {
        try {
            $data = $this->checkoutRepository->findAll();
            return ApiResponseClass::sendResponse($data, '', 200);

        } catch (Exception $e) {

            return ApiResponseClass::sendFail("Checkout Delete Fail : {$e->getMessage()}");

        }
    }

    public function findByIdUser($id)
    {
        try {
            $data = $this->checkoutRepository->findByIdUser($id);
            return ApiResponseClass::sendResponse($data, '', 200);

        } catch (Exception $e) {

            return ApiResponseClass::sendFail("Checkout Delete Fail id $$id : {$e->getMessage()}");

        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return ApiResponseClass::sendFail('not implement', '', 301);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCheckoutRequest $request)
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
            return ApiResponseClass::sendResponse(new CheckoutResource($data), 'Checkout Create Successful', 201);

        } catch (\Exception $ex) {
//            return ApiResponseClass::rollback($ex);
            return ApiResponseClass::sendFail('Checkout Create Fail', $ex->getMessage(), 404);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = $this->checkoutRepository->findId($id);
            return ApiResponseClass::sendResponse(new CheckoutResource($data), 'success', 200);
        } catch (Exception $e) {
            return ApiResponseClass::sendFail('Checkout Delete Fail', $e->getMessage(), 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checkout $checkout)
    {
        return ApiResponseClass::sendResponse('not implement', '', 404);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCheckoutRequest $request, $id)
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
            return ApiResponseClass::sendResponse('Checkout Update Successful', '', 201);

        } catch (Exception $e) {
//            return ApiResponseClass::rollback($e);
            return ApiResponseClass::sendResponse('Checkout Update Fail', $e->getMessage(), 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->checkoutRepository->delete($id);
            return ApiResponseClass::sendResponse('Checkout Delete Successful', '', 204);
        } catch (\Exception $ex) {
            return ApiResponseClass::sendResponse('Checkout Delete Fail', $ex->getMessage(), 404);
        }
    }
}
