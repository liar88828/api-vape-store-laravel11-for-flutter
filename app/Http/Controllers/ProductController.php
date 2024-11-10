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

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {

        try {
            $details = [
                'name' => $request->name,
                'qty' => $request->qty,
                'price' => $request->price,
                'description' => $request->description,
                'id_user' => $request->id_user
            ];

//            DB::beginTransaction();
            $product = $this->productRepository->store($details);

//            DB::commit();
            return ApiResponseClass::sendResponse(new ProductResource($product), 'Product Create Successful', 200);

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
            return ApiResponseClass::sendFail("The Data Product is not found $id", $ex, 404);

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

        try {
            $details = [
                'name' => $request->name,
                'qty' => $request->qty,
                'price' => $request->price,
                'description' => $request->description,
                'id_user' => $request->id_user
            ];
//            DB::beginTransaction();
            $product = $this->productRepository->update($details, $id);

//            DB::commit();
            return ApiResponseClass::sendResponse('Product Update Successful', '', 200);

        } catch (\Exception $ex) {
//            DB::disconnect();

            return ApiResponseClass::sendFail('The Product is fail', $ex, 404);
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
        } catch (\Exception $ex) {
            return ApiResponseClass::sendFail('Product Delete Fail', $ex->getMessage(), 404);
        }
    }
}
