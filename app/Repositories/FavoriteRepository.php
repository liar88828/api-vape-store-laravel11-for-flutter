<?php

namespace App\Repositories;

use App\Interfaces\FavoriteRepositoryInterface;
use App\Models\Favorite;

class FavoriteRepository implements FavoriteRepositoryInterface
{


    public function findAll()
    {
        return Favorite::all();
    }

    public function findId(int $id)
    {
        return Favorite::query()->findOrFail($id);
    }

    public function addId(int $id, array $data)
    {

        $response = Favorite::query()
            ->where('id','=', $id)
            ->get();
        if ($response->isEmpty()) {
            return Favorite::query()->create($data);
        } else {
              Favorite::destroy($id);
        }
    }

    public function removeId(int $id)
    {
          Favorite::destroy($id);

    }
}
