<?php

namespace App\Interfaces;

interface CheckoutRepositoryInterface
{
    public function findAll();

    public function findId(int $id);

    public function findByIdUser(int $id);

    public function findAllCheckout(int $id);

    public function createSingle(array $checkout, array $id_trolley);

    public function createMany(array $checkout, array $id_trolley);

    public function update(array $data, int $id);

    public function delete(int $id);
}
