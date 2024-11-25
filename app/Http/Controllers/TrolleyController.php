<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\StoreTrolleyRequest;
use App\Http\Requests\UpdateTrolleyRequest;
use App\Http\Resources\TrolleyResource;
use App\Interfaces\TrolleyRepositoryInterface;
use App\Models\Trolley;
use Exception;
use Illuminate\Http\JsonResponse;
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
            return ApiResponseClass::sendResponse(TrolleyResource::collection($data), '');

        } catch (Exception $e) {
            return ApiResponseClass::sendFail('Trolley Delete Fail' . $e->getMessage());
        }
        //
    }

    public function findByUserId($id)
    {
        try {
            $data = $this->trolleyRepository->findByUserId($id);
            return ApiResponseClass::sendResponse(TrolleyResource::collection($data), 'success');

        } catch (Exception $e) {
            return ApiResponseClass::sendFail("Trolley Find by user $id Fail " . $e->getMessage());
        }
    }


    public function findByCheckoutId($id)
    {
        try {
            $data = $this->trolleyRepository->findByCheckoutId($id);
            return ApiResponseClass::sendResponse(TrolleyResource::collection($data), 'success');

        } catch (Exception $e) {
            return ApiResponseClass::sendFail("Trolley Find by user $id Fail " . $e->getMessage());
        }
        //
    }

    public function findByUserIdCount($id): JsonResponse
    {
        try {
            $data = $this->trolleyRepository->findByUserIdCount($id);
            return ApiResponseClass::sendResponse($data, 'success');
        } catch (Exception $e) {
            return ApiResponseClass::sendFail("Trolley Count Fail user id $$id " . $e->getMessage());
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return ApiResponseClass::sendFail('not implement', 301);

    }

    /**
     * Store a newly created resource in storage.
     * @param mixed|StoreTrolleyRequest|Trolley $request
     * @return JsonResponse
     */
    public function store(StoreTrolleyRequest $request)
    {
        try {
            /** @var Trolley $trolley */
            $trolley = [
                'id_product' => $request->id_product,
                'id_user' => $request->id_user,
                'type' => $request->type,
                'qty' => $request->qty,
            ];
//            print_r($trolley);
            $this->trolleyRepository->create($trolley);

            return ApiResponseClass::sendResponse($trolley, 'Trolley Create Successful');

        } catch (Exception $e) {
            return ApiResponseClass::sendFail('Trolley Create Fail ' . $e->getMessage());

        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $response = $this->trolleyRepository->findId($id);
            return ApiResponseClass::sendResponse(new TrolleyResource($response), '');

        } catch (Exception $ex) {
            return ApiResponseClass::sendFail("The Data Trolley is not found $id", '');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trolley $trolley)
    {
        return ApiResponseClass::sendFail('not implement', '', 301);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrolleyRequest $request, $id)
    {

        try {
            $trolley = [
                'qty' => $request->qty,
                'id_product' => $request->id_product,
                'type' => $request->type,
                'id_user' => $request->id_user,
//                'id_checkout' => $request->id_checkout ?? null,
            ];
            DB::beginTransaction();
            $this->trolleyRepository->update($trolley, $id);

            DB::commit();
            return ApiResponseClass::sendResponse('Trolley Update Successful', '');
        } catch (Exception $e) {
            DB::rollBack();
            return ApiResponseClass::sendFail('Trolley Update Fail' . $e->getMessage());

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->trolleyRepository->delete($id);
            return ApiResponseClass::sendResponse("Trolley Delete Successful", "success delete $id");
        } catch (Exception $e) {
            return ApiResponseClass::sendFail("Trolley Fail Delete id $id" . $e->getMessage());
        }
    }
}
