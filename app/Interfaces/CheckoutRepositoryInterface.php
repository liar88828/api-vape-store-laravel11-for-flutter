<?php

namespace App\Interfaces;

use App\Models\Checkout;

interface CheckoutRepositoryInterface
{
    public function findAll();
    public function findId(int  $id);
    public function create(array $data);
    public function update(array $data, int $id);
    public function delete(int  $id);
}
