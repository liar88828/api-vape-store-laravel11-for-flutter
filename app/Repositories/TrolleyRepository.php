<?php

namespace App\Repositories;

use App\Interfaces\TrolleyRepositoryInterface;
use App\Models\Trolley;
use Exception;

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
            ->where('trolleys.is_checkout', false)
            ->get(['trolleys.*',
                'trolleys.id as id_trolley',
                'trolleys.id_user as trolley_id_user',
                'trolleys.qty as trolley_qty',
                'products.*']);

    }

    public function findByCheckoutId($id)
    {
        return Trolley::query()
            ->join('products', 'products.id', '=', 'trolleys.id_product')
            ->where('trolleys.id_checkout', $id)
            ->where('trolleys.is_checkout', true)
            ->get(['trolleys.*',
                'trolleys.id as id_trolley',
                'trolleys.id_user as trolley_id_user',
                'trolleys.qty as trolley_qty',
                'products.*']);
    }

    public function findByUserIdCount($id)
    {
        return Trolley::query()->where('id_user', $id)
            ->where('is_checkout', false)
            ->count();

    }

    public function findId($id)
    {
        return Trolley::query()->findOrFail($id);
    }

    /**
     * @param Trolley $data
     * @return bool
     */
    public function create(array $data)
    {
        $response = Trolley::query()
            ->where([
                "id_product" => $data['id_product'],
                "id_user" => $data['id_user'],
                'type' => $data['type'],
                'is_checkout' => false,
                "qty" => $data['qty']
            ])
            ->first();
//        print_r($response['id']);
        if ($response) {
            return Trolley::query()
                ->where('id', $response['id'])
                ->update(["qty" => $data['qty']]);
        } else {
            return Trolley::query()->create($data);
        }
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
            throw new Exception("Fail Delete id $id");
        } else {
            return true;
        }
    }


}
