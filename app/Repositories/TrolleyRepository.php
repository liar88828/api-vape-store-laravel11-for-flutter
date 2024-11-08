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

    public function findId($id)
    {
        return Trolley::query()->findOrFail($id);
    }

//    public function create(array $data)
//    {
////        return Trolley::query()->where('');
//    }

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
          Trolley::destroy($id);
    }
}
