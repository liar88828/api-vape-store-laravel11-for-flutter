<?php

namespace App\Repositories;

use App\Interfaces\CheckoutRepositoryInterface;
use App\Models\Checkout;
use App\Models\CheckoutList;
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


    public function findAllCheckout(int $id)
    {
        return CheckoutList::query()
            ->join('products', 'products.id', '=', 'checkout_lists.id_product')
            ->where('checkout_lists.id', $id)
            ->get([
                'checkout_lists.id as id_checkout_lists',
                'products.id as id_product',
                'products.*']);
    }

    public function findId(int $id)
    {
        return Checkout::query()->findOrFail($id);
    }

    /**
     * @param Checkout| $data
     * @return bool
     */
    public function createMany(array $checkout, array $id_trolley)
    {
        DB::beginTransaction();

        $response = Checkout::query()->create($checkout);

        if ($response) {
            foreach ($id_trolley as $id) {
                Trolley::query()->where("id", $id)->update([
                    'id_checkout' => $response['id'],
                    'is_checkout' => true
                ]);
            }
            DB::commit();
            return $response;
        } else {
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


    public function createSingle(array $checkout, array $id_trolley)
    {
        // TODO: Implement createSingle() method.
    }
}
