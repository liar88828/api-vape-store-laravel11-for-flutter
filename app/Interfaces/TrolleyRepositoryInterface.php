<?php

namespace App\Interfaces;

interface TrolleyRepositoryInterface
{
    public function findAll();
    public function findId($id);
//    public function create(array $data);
    public function update(array $data,$id);
    public function delete($id);
}
