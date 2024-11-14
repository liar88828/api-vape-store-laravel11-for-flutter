<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\StoreBankRequest;
use App\Http\Requests\UpdateBankRequest;
use App\Http\Resources\BankResource;
use App\Interfaces\BankRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;

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
    public function index(): JsonResponse
    {
        try {
            $data = $this->bankRepository->findAll();
            return ApiResponseClass::sendResponse($data, '');


        } catch (Exception $exception) {
            return ApiResponseClass::sendFail('Bank Delete Fail', $exception->getMessage());

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): JsonResponse
    {
        return ApiResponseClass::sendFail('Bank api create is not implement', 301);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankRequest $request): JsonResponse
    {
        try {

            $data = [
                "name" => $request->name,
                "phone" => $request->phone,
                "address" => $request->address,
                "accounting" => $request->accounting,
            ];
            $this->bankRepository->store($data);
            return ApiResponseClass::sendResponse(new BankResource($data), 'Bank Create Successful');
        } catch (Exception $exception) {
            return ApiResponseClass::sendFail('Bank Create Fail' . $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        try {
            $data = $this->bankRepository->findById($id);
            return ApiResponseClass::sendResponse(new BankResource($data), "Bank Detail Successful $id", 201);
        } catch (Exception $exception) {
            return ApiResponseClass::sendFail("Bank Detail Fail $id " . $exception->getMessage(), 404);

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(): JsonResponse
    {
        return ApiResponseClass::sendFail('bank edit not implement', 301);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBankRequest $request, $id): JsonResponse
    {
        try {
            $data = [
                "name" => $request->name,
                "phone" => $request->phone,
                "address" => $request->address,
                "accounting" => $request->accounting,
            ];
            $this->bankRepository->updateId($data, $id);
            return ApiResponseClass::sendResponse($data, "Bank Update Successful $id");
        } catch (Exception $exception) {
            return ApiResponseClass::sendFail("Bank Update Fail $id" . $exception->getMessage(), 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->bankRepository->deleteId($id);
            return ApiResponseClass::sendResponse('', "Bank Delete Successful $id");
        } catch (Exception $exception) {
            return ApiResponseClass::sendFail("Bank Delete Fail $id" . $exception->getMessage());
        }
    }
}
