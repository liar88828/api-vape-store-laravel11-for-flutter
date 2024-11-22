<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\StoreFavoriteListRequest;
use App\Http\Requests\StoreFavoriteRequest;
use App\Http\Requests\UpdateFavoriteRequest;
use App\Http\Resources\FavoriteResource;
use App\Interfaces\FavoriteRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class FavoriteController extends Controller
{
    private FavoriteRepositoryInterface $favoriteRepository;

    public function __construct(FavoriteRepositoryInterface $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->favoriteRepository->findAll();
            return ApiResponseClass::sendResponse(FavoriteResource::collection($data), 'success find all data');

        } catch (Exception $exception) {
            return ApiResponseClass::sendFail("Favorite Delete Fail :{$exception->getMessage()} ");
        }
        //
    }

    public function findByIdUser($id): JsonResponse
    {
        try {
            Log::info("favorite findByIdUser : $id");
            $data = $this->favoriteRepository->findByIdUser($id);
            return ApiResponseClass::sendResponse(FavoriteResource::collection($data), "Success Get Data Favorite by user $id", 201);

        } catch (Exception $exception) {
            return ApiResponseClass::sendFail('Favorite Create Fail : ' . $exception->getMessage());
        }
        //
    }

    public function findByIdList($id): JsonResponse
    {
        try {
            $data = $this->favoriteRepository->findByIdList($id);
            return ApiResponseClass::sendResponse(FavoriteResource::collection($data), "Success Get Data Favorite by user $id", 201);

        } catch (Exception $exception) {
            return ApiResponseClass::sendFail('Favorite Create Fail :' . $exception->getMessage());
        }
        //
    }

    public function findByIdUserCount($id): JsonResponse
    {
        try {
            $data = $this->favoriteRepository->findByIdUserCount($id);
            return ApiResponseClass::sendResponse($data, "Success Get Data Favorite by user $id", 201);

        } catch (Exception $exception) {
            return ApiResponseClass::sendFail('Favorite Create Fail : ' . $exception->getMessage());
        }
        //
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
    public function store(StoreFavoriteRequest $request): JsonResponse
    {
        try {
            $data = [
//                'id_product' => $request->id_product,
                'id_user' => $request->id_user,
                'title' => $request->title,
                'description' => $request->description,
            ];
//            print_r($data);
            $this->favoriteRepository->create($data);
            return ApiResponseClass::sendResponse($data, 'Favorite Create Successful');
        } catch (Exception $ex) {
            return ApiResponseClass::sendFail('Fail Create Favorite ' . $ex, 400);
//
        }
    }

    public function addToFavoriteList(StoreFavoriteListRequest $request): JsonResponse
    {
        try {
            $data = [
                'id_favorite' => $request->id_favorite,
                'id_product' => $request->id_product,
//                'id_user' => $request->id_user,
            ];
//            print_r($data);
            $this->favoriteRepository->addToFavoriteList($data);
            return ApiResponseClass::sendResponse($data, 'Favorite Create Successful add favorite list');
        } catch (Exception $exception) {
            return ApiResponseClass::sendFail('Fail Create Favorite ' . $exception->getMessage(), 400);
//
        }
    }

    public function deleteToFavoriteList($id): JsonResponse
    {
        try {

            $this->favoriteRepository->deleteToFavoriteList($id);
            return ApiResponseClass::sendResponse($id, 'Success Delete Favorite List');
        } catch (Exception $exception) {
            return ApiResponseClass::sendFail('Fail Delete Favorite ' . $exception->getMessage(), 400);
//
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        try {
            $response = $this->favoriteRepository->findId($id);
//            print_r($response);
            return ApiResponseClass::sendResponse(new FavoriteResource($response), 'success', 201);
        } catch (Exception $ex) {
            return ApiResponseClass::sendFail("The Data Favorite is not found $id" . $ex->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): JsonResponse
    {
        return ApiResponseClass::sendFail('not implement :id ' . $id, 301);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFavoriteRequest $request, $id): JsonResponse
    {
        try {
            $data = [
//                'id_user' => $request->id_user,
//                'id_product' => $request->id_product,
                'title' => $request->title,
                'description' => $request->description,
            ];

//            DB::beginTransaction();
//            DB::commit();
            $this->favoriteRepository->update($id, $data);
            return ApiResponseClass::sendResponse($data, 'Favorite Update Successful');

        } catch (Exception $exception) {
//            return ApiResponseClass::rollback($ex);
            return ApiResponseClass::sendFail("Fail Update Favorite : {$exception->getMessage()}");

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->favoriteRepository->removeId($id);
            return ApiResponseClass::sendResponse("Favorite Delete Successful $id", "success delete favorite id :$id");

        } catch (Exception $exception) {
            return ApiResponseClass::sendFail("Favorite Delete Fail id $id : {$exception->getMessage()}", 404);
        }
    }
}
