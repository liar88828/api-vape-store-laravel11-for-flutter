<?php

namespace App\Interfaces;

interface TrolleyRepositoryInterface
{
    public function findAll( );
    public function findByUserId($id);
    public function findByUserIdCount($id);
    public function findId($id);
    public function create(array $data);
    public function update(array $data,$id);
    public function delete($id);
}
