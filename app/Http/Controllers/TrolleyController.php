<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\StoreTrolleyRequest;
use App\Http\Requests\UpdateTrolleyRequest;
use App\Http\Resources\TrolleyResource;
use App\Interfaces\TrolleyRepositoryInterface;
use App\Models\Trolley;

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

    public function findByUserId($id)
    {
        try {
            $data = $this->trolleyRepository->findByUserId($id);
            return ApiResponseClass::sendResponse(TrolleyResource::collection($data), '', 200);

        } catch (\Exception $e) {
            return ApiResponseClass::sendResponse("Trolley Find by user $id Fail", $e, 404);
        }
        //
    }

    public function findByUserIdCount($id)
    {
        try {
            $data = $this->trolleyRepository->findByUserIdCount($id);
//            print_r($data);
            return ApiResponseClass::sendResponse(
//                TrolleyResource::collection($data)
                $data
                , '', 200);

        } catch (\Exception $e) {
            return ApiResponseClass::sendResponse("Trolley Count Fail user id $$id", '', 404);
        }
        //
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return ApiResponseClass::sendResponse('not implement', '', 404);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrolleyRequest $request)
    {
        try {
            $trolley = [
                'qty' => $request->qty,
                'id_product' => $request->id_product,
                'id_user' => $request->id_user,
            ];
            $this->trolleyRepository->create($trolley);
            return ApiResponseClass::sendResponse('Trolley Create Successful', '', 200);

        } catch (\Exception $ex) {
            return ApiResponseClass::sendResponse('Trolley Create Fail', $ex, 404);

        }
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
        return ApiResponseClass::sendResponse('not implement', '', 404);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrolleyRequest $request, $id)
    {

        try {
            $trolley = [
                'qty' => $request->qty,
//                'id_checkout' => $request->id_checkout ?? null,
                'id_product' => $request->id_product,
                'id_user' => $request->id_user,
            ];
//print_r($trolley);
//            DB::beginTransaction();
            $this->trolleyRepository->update($trolley, $id);

//            DB::commit();
            return ApiResponseClass::sendResponse('Trolley Update Successful', '', 200);

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
            $this->trolleyRepository->delete($id);
            return ApiResponseClass::sendResponse('Trolley Delete Successful', '');
        } catch (\Exception $ex) {
            return ApiResponseClass::sendResponse("Trolley Fail Delete id $id", '', 404);
        }
    }
}
