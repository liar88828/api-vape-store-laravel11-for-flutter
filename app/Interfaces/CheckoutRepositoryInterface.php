<?php

namespace App\Interfaces;

interface CheckoutRepositoryInterface
{
    public function findAll();
    public function findId(int  $id);

    public function findByIdUser(int $id);
    public function create(array $data);
    public function update(array $data, int $id);
    public function delete(int  $id);
}
