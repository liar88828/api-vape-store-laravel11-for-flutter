<?php

namespace App\Interfaces;

interface FavoriteRepositoryInterface
{
    public function findAll();

    public function findId(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function removeId(int $id);

}
