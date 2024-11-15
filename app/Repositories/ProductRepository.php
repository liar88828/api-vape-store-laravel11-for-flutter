<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function index(array $filters = [])
    {
        $query = Product::query();

        // Apply filters dynamically
        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }
        if (isset($filters['order'])) {
            $query->orderBy('price', $filters['order'] == 'Low Price' ? 'asc' : 'desc');
        }

        return $query->get();

    }


    public function favorite()
    {
//        return Product::query()->get();
        return Product::query()->orderBy('updated_at','desc')
            ->limit(5)
            ->get();

    }

    public function newProduct()
    {
        return Product::query()->orderBy('created_at','desc')
            ->limit(5)
            ->get();

    }

    public function flashSale()
    {
        return Product::query()
            ->orderBy('qty','asc')
            ->limit(5)
            ->get();
    }

    public function getById($id)
    {
        return Product::findOrFail($id);
    }

    public function store(array $data)
    {
        return Product::create($data);
    }

    public function update(array $data, $id)
    {
        return Product::whereId($id)->update($data);
    }

    public function delete($id): bool
    {
        $response = Product::query()->where('id', $id)->delete();
        if ($response == "0") {
            throw new \Exception('Failed to delete');
        } else {
            return true;
        }
    }


}
