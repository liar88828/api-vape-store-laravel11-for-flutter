<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

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
    public function index(Request $request)
    {

        $filters = $request->only(['name', 'category', 'order']);
//        print_r($filters);
        $data = $this->productRepository->index($filters);
        return ApiResponseClass::sendResponse(ProductResource::collection($data), '', 200);

    }


    public function newProduct()
    {
        $data = $this->productRepository->newProduct();
        return ApiResponseClass::sendResponse(ProductResource::collection($data), '', 200);

    }


    public function favorite()
    {
        $data = $this->productRepository->favorite();
        return ApiResponseClass::sendResponse(ProductResource::collection($data), '', 200);

    }


    public function flashSale()
    {
        $data = $this->productRepository->favorite();
        return ApiResponseClass::sendResponse(ProductResource::collection($data), '', 200);

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
     */
    public function store(StoreProductRequest $request)
    {

        try {
            $data = [
                'name' => $request->name,
                'qty' => $request->qty,
                'price' => $request->price,
                'description' => $request->description,
                'category' => $request->category,
                'id_user' => $request->id_user
            ];

//            DB::beginTransaction();
//            print_r($request->toArray());
            $response = $this->productRepository->store($data);

//            DB::commit();
            return ApiResponseClass::sendResponse(new ProductResource($data), 'Product Create Successful', 200);

        } catch (Exception $ex) {
            return ApiResponseClass::sendFail($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $product = $this->productRepository->getById($id);
            return ApiResponseClass::sendResponse(new ProductResource($product), '', 201);
        } catch (Exception $ex) {
            return ApiResponseClass::sendFail("The Data Product is not found $id " . $ex->getMessage(), 404);

        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return ApiResponseClass::sendFail('not implement', 301);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {

        try {
            $data = [
                'name' => $request->name,
                'qty' => $request->qty,
                'price' => $request->price,
                'description' => $request->description,
                'id_user' => $request->id_user
            ];
//            DB::beginTransaction();
            $product = $this->productRepository->update($data, $id);

//            DB::commit();
            return ApiResponseClass::sendResponse('Product Update Successful', '', 200);

        } catch (Exception $ex) {
            return ApiResponseClass::sendFail('The Product is fail :' . $ex, 404);
        }
    }

    /**
     * this destroy cant delete table because that value is relational with other table. if you want delete that table you must be delete other data  relational with this table (favorite, trolley)
     */
    public function destroy($id)
    {
        try {
            $this->productRepository->delete($id);
            return ApiResponseClass::sendResponse('Product Delete Successful', '', 200);
        } catch (Exception $ex) {
            return ApiResponseClass::sendFail('Product Delete Fail', $ex->getMessage(), 404);
        }
    }
}
