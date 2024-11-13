<?php

namespace App\Interfaces;

interface DeliveryRepositoryInterface
{
    function findAll();

    function findById(int $id);

    function store(array $data);

    function updateId(array $data, int $id);

    function deleteId(int $id);
}
