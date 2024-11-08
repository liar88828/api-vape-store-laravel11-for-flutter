<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Resources\FavoriteResource;
use App\Interfaces\FavoriteRepositoryInterface;
use App\Models\Favorite;
use App\Http\Requests\StoreFavoriteRequest;
use App\Http\Requests\UpdateFavoriteRequest;
use Illuminate\Support\Facades\DB;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFavoriteRequest $request)
    {

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFavoriteRequest $request, $id)
    {
        try {
            $favorite = [
                'id_user' => $request->id_user,
                'id_product' => $request->id_product,
                'title' => $request->title,
                'description' => $request->description,
            ];

            DB::beginTransaction();
            $product = $this->favoriteRepository->addId($id, $favorite);
//            print_r($product);
            DB::commit();
            return ApiResponseClass::sendResponse(new FavoriteResource($product), 'Trolley Create Successful', 201);

        } catch (\Exception $ex) {
//            return ApiResponseClass::rollback($ex);
            return ApiResponseClass::sendResponse('Fail Create Favorite', $ex, 201);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $response = $this->favoriteRepository->removeId($id);
            if ($response) {
                return ApiResponseClass::sendResponse('Favorite Delete Successful', '', 204);
            } else {
                return ApiResponseClass::sendResponse('The Data Favorite is not found', '', 404);
            }

        } catch (\Exception $ex) {
            return ApiResponseClass::sendResponse('Favorite Delete Fail', '', 404);
        }
    }
}
