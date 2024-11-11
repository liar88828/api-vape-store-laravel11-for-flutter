<?php

namespace App\Repositories;

use App\Interfaces\CheckoutRepositoryInterface;
use App\Models\Checkout;

class CheckoutRepository implements CheckoutRepositoryInterface
{

    public function findAll()
    {
        return Checkout::all();
    }

    public function findByIdUser(int $id)
    {
        return Checkout::query()->where("id_user", $id)
            ->limit(100)
            ->get();

    }
    public function findId(int $id)
    {
        return Checkout::query()->findOrFail($id);
    }

    public function create(array $data)
    {
        return Checkout::query()->create($data);
    }

    public function update(array $data, int $id)
    {
        Checkout::query()->where('id','=', $id)->update($data);
    }

    public function delete($id)
    {
        $response = Checkout::query()->where('id', $id)->delete();
        if (!$response) {
            throw  new \Exception('Fail Delete Checkout');
        }
        return true;
    }


}
