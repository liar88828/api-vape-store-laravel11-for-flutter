<?php

namespace App\Repositories;

use App\Interfaces\TrolleyRepositoryInterface;
use App\Models\Trolley;

class TrolleyRepository implements TrolleyRepositoryInterface
{
    /**
     * Create a new class instance.
     */

    public function findAll()
    {
        return Trolley::all();
    }

    public function findByUserId($id)
    {
        return Trolley::query()
            ->join('products', 'products.id', '=', 'trolleys.id_product')
            ->where('trolleys.id_user', $id)
            ->get(['trolleys.*',
                'trolleys.id as id_trolley',
                'trolleys.id_user as trolley_id_user',
                'products.*']);

    }

    public function findByUserIdCount($id)
    {
        return Trolley::query()->where('id_user', $id)->count();

    }

    public function findId($id)
    {
        return Trolley::query()->findOrFail($id);
    }

    public function create(array $data)
    {
        return Trolley::query()->create($data);

    }

    public function update(array $data, $id)
    {
        $response = Trolley::query()
            ->where('id', '=', $id)
            ->get();

        if ($response->isEmpty()) {
            Trolley::query()->create($data);
        } else {
            Trolley::query()->where($id)->update($data);
        }
    }

    public function delete($id)
    {
        $response = Trolley::destroy($id);
        if ($response == '0') {
            throw new \Exception("Fail Delete id $id");
        } else {
            return true;
        }
    }


}
