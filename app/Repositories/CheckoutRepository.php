<?php

namespace App\Repositories;

use App\Interfaces\CheckoutRepositoryInterface;
use App\Models\Checkout;
use App\Models\Trolley;
use Exception;
use Illuminate\Support\Facades\DB;

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

    /**
     * @param Checkout| $data
     * @return bool
     */
    public function create(array $checkout, array $id_trolley)
    {
        DB::beginTransaction();

        $response = Checkout::query()->create($checkout);
        if ($response) {
            foreach ($id_trolley as $trolleyId) {
                Trolley::query()->
                where('id', $trolleyId)
                    ->update(['id_checkout' => $response['id']]);
            }
            DB::commit();
            return $response;
        } else {
            DB::rollBack();
            throw new Exception('Fail Create Checkout');
        }
    }

    public function update(array $data, int $id)
    {
        DB::beginTransaction();
        $response = Checkout::query()->where('id', '=', $id)->update($data);
        print_r($response);
        if ($response) {
            DB::commit();
            return true;
        } else {
            DB::rollBack();
            throw new Exception('Fail Create Checkout');
        }
    }

    public function delete($id)
    {
        $response = Checkout::query()->where('id', $id)->delete();
        if (!$response) {
            throw  new Exception('Fail Delete Checkout');
        }
        return true;
    }


}
