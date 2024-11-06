<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Resources\ProductResource;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{


    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->productRepository->index();
        return ApiResponseClass::sendResponse(ProductResource::collection($data), '', 200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $details = [
            'name' => $request->name,
            'details' => $request->details
        ];
//        print_r($details);

        DB::beginTransaction();
        try {
            $product = $this->productRepository->store($details);

            DB::commit();
            return ApiResponseClass::sendResponse(new ProductResource($product), 'Product Create Successful', 201);

        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {

            $product = $this->productRepository->getById($id);
            return ApiResponseClass::sendResponse(new ProductResource($product), '', 200);
        } catch (\Exception $ex) {
            return ApiResponseClass::sendResponse("The Data Product is not found $id", '', 404);

        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $updateDetails = [
            'name' => $request->name,
            'details' => $request->details
        ];
        DB::beginTransaction();
        try {
            $product = $this->productRepository->update($updateDetails, $id);

            DB::commit();
            return ApiResponseClass::sendResponse('Product Update Successful', '', 201);

        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $response = $this->productRepository->delete($id);
            if ($response) {

                return ApiResponseClass::sendResponse('Product Delete Successful', '', 204);
            } else {
                return ApiResponseClass::sendResponse('The Data Product is not found', '', 404);
            }

        } catch (\Exception $ex) {
            return ApiResponseClass::sendResponse('Product Delete Fail', '', 404);
        }

    }
}
