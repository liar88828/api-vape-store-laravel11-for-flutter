<?php

namespace App\Repositories;

use App\Interfaces\DeliveryRepositoryInterface;
use App\Models\Delivery;

class DeliveryRepository implements DeliveryRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    function findAll()
    {
        return Delivery::all();
    }

    function findById(int $id)
    {
        return Delivery::query()->findOrFail($id);

    }

    function store(array $data)
    {
        return Delivery::query()->create($data);
    }

    function updateId(array $data, int $id)
    {
        return Delivery::query()->where('id', $id)->update($data);
    }

    function deleteId(int $id)
    {
        return Delivery::query()->where('id', $id)->delete();
    }
}
