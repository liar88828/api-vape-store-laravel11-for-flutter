<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function index(array $filters);
    public function favorite();
    public function newProduct();
    public function flashSale();
    public function getById($id);
    public function store(array $data);
    public function update(array $data,$id);
    public function delete($id):bool;
}
