<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function index()
    {
        return Product::all();
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
