<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\StoreFavoriteRequest;
use App\Http\Requests\UpdateFavoriteRequest;
use App\Http\Resources\FavoriteResource;
use App\Interfaces\FavoriteRepositoryInterface;
use App\Models\Favorite;

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
    public function index()
    {
        try {
            $data = $this->favoriteRepository->findAll();
            return ApiResponseClass::sendResponse(FavoriteResource::collection($data), '', 200);

        } catch (\Exception $e) {
            return ApiResponseClass::sendResponse('Favorite Delete Fail', '', 404);
        }
        //
    }

    public function findByIdUser($id)
    {
        try {
            $data = $this->favoriteRepository->findByIdUser($id);
            return ApiResponseClass::sendResponse(FavoriteResource::collection($data), "Success Get Data Favorite by user $id", 200);

        } catch (\Exception $e) {
            return ApiResponseClass::sendResponse('Favorite Create Fail', '', 404);
        }
        //
    }



    public function findByIdList($id)
    {
        try {
            $data = $this->favoriteRepository->findByIdList($id);
            return ApiResponseClass::sendResponse(FavoriteResource::collection($data), "Success Get Data Favorite by user $id", 200);

        } catch (\Exception $e) {
            return ApiResponseClass::sendResponse('Favorite Create Fail', '', 404);
        }
        //
    }

    public function findByIdUserCount($id)
    {
        try {
            $data = $this->favoriteRepository->findByIdUserCount($id);
            return ApiResponseClass::sendResponse($data, "Success Get Data Favorite by user $id", 200);

        } catch (\Exception $e) {
            return ApiResponseClass::sendResponse('Favorite Create Fail', '', 404);
        }
        //
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return ApiResponseClass::sendResponse('not implement', 'not implement', 301);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFavoriteRequest $request)
    {
        try {
            $favorite = [
                'id_user' => $request->id_user,
//                'id_product' => $request->id_product,
                'title' => $request->title,
                'description' => $request->description,
            ];
//            print_r($favorite);
            $response = $this->favoriteRepository->create($favorite);
            return ApiResponseClass::sendResponse(new FavoriteResource($response), 'Favorite Create Successful');
        } catch (\Exception $ex) {
            return ApiResponseClass::sendResponse('Fail Create Favorite', $ex, 401);
//
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $response = $this->favoriteRepository->findId($id);
//            print_r($response);
            return ApiResponseClass::sendResponse(new FavoriteResource($response), '', 200);
        } catch (\Exception $ex) {
            return ApiResponseClass::sendResponse("The Data Trolley is not found $id", '', 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Favorite $favorite)
    {
        return ApiResponseClass::sendResponse('not implement', 'not implement', 301);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFavoriteRequest $request, $id)
    {
        try {
            $favorite = [
                'id_user' => $request->id_user,
//                'id_product' => $request->id_product,
                'title' => $request->title,
                'description' => $request->description,
            ];

//            DB::beginTransaction();
            $response = $this->favoriteRepository->update($id, $favorite);
//            print_r($product);
//            DB::commit();
            return ApiResponseClass::sendResponse(new FavoriteResource($response), 'Trolley Create Successful');

        } catch (\Exception $ex) {
//            return ApiResponseClass::rollback($ex);
            return ApiResponseClass::sendResponse('Fail Create Favorite', $ex, 404);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->favoriteRepository->removeId($id);
            return ApiResponseClass::sendResponse('Favorite Delete Successful', '');

        } catch (\Exception $ex) {
            return ApiResponseClass::sendResponse('Favorite Delete Fail', $ex->getMessage(), 404);
        }
    }
}
