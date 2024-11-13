<?php

namespace App\Repositories;

use App\Interfaces\BankRepositoryInterface;
use App\Models\Bank;

class BankRepository implements BankRepositoryInterface
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
        return Bank::all();
    }

    function findById(int $id)
    {
        return Bank::query()->findOrFail($id);

    }

    function store(array $data)
    {
        return Bank::query()->create($data);
    }

    function updateId(array $data, int $id)
    {
        return Bank::query()->where('id', $id)->update($data);
    }

    function deleteId(int $id)
    {
        return Bank::query()->where('id', $id)->delete();
    }
}
