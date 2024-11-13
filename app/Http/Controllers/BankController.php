<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\StoreBankRequest;
use App\Http\Requests\UpdateBankRequest;
use App\Http\Resources\BankResource;
use App\Interfaces\BankRepositoryInterface;

class BankController extends Controller
{

    private BankRepositoryInterface $bankRepository;

    public function __construct(BankRepositoryInterface $bankRepository)
    {
        $this->bankRepository = $bankRepository;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = $this->bankRepository->findAll();
            return ApiResponseClass::sendResponse($data, '');


        } catch (\Exception $exception) {
            return ApiResponseClass::sendFail('Bank Delete Fail', $exception->getMessage(), 404);

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return ApiResponseClass::sendFail('Bank api create is not implement', '', 301);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankRequest $request)
    {
        try {

            $data = $this->bankRepository->store($request->toArray());
            return ApiResponseClass::sendResponse(new BankResource($data), 'Bank Create Successful', 201);
        } catch (\Exception $exception) {
            return ApiResponseClass::sendFail('Bank Create Fail', $exception->getMessage(), 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = $this->bankRepository->findById($id);
            return ApiResponseClass::sendResponse(new BankResource($data), "Bank Detail Successful $id", 200);
        } catch (\Exception $exception) {
            return ApiResponseClass::sendFail("Bank Detail Fail $id", $exception->getMessage(), 404);

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
    public function update(UpdateBankRequest $request, $id)
    {
        try {

            $this->bankRepository->updateId($request->toArray(), $id);
            return ApiResponseClass::sendResponse($request->all(), "Bank Update Successful $id", 200);
        } catch (\Exception $exception) {
            return ApiResponseClass::sendFail("Bank Update Fail $id", $exception->getMessage(), 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->bankRepository->deleteId($id);
            return ApiResponseClass::sendResponse('', "Bank Delete Successful $id");
        } catch (\Exception $exception) {
            return ApiResponseClass::sendFail("Bank Delete Fail $id", $exception->getMessage());
        }
    }
}
