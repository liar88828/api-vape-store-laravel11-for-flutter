<?php

namespace App\Repositories;

use App\Interfaces\FavoriteRepositoryInterface;
use App\Models\Favorite;
use App\Models\FavoriteList;

class FavoriteRepository implements FavoriteRepositoryInterface
{


    public function findAll()
    {
        return Favorite::all();
    }

    public function findByIdUser($id)
    {
        return Favorite::query()->where('id_user', $id)->get();
    }

    public function findByIdList($id)
    {
//        return Favorite::query()->where('id', $id)->get();
        return FavoriteList::query()->join('products', 'products.id', '=', 'favorite_lists.id_product')
            ->where('favorite_lists.id_favorite', $id) // Replace $idFavorite with the desired ID
            ->orderBy('favorite_lists.updated_at', 'desc')
            ->limit(20)
            ->get([
                'favorite_lists.id as favorite_lists_id'
                , 'favorite_lists.*'
                , 'products.id as product_id'
                , 'products.*']);
    }

    public function findId(int $id)
    {
        return Favorite::query()->findOrFail($id);
    }


    public function create(array $data)
    {
        return Favorite::query()->create($data);
    }


    public function update(int $id, array $data)
    {

        $response = Favorite::query()
            ->where('id', $id)
            ->get();
        if ($response->isEmpty()) {
            return Favorite::query()->create($data);
        } else {
            return Favorite::query()->where('id', $id)->update($data);

//            Favorite::destroy($id);
        }
        return false;
    }

    public function removeId(int $id)
    {
        $response = Favorite::destroy($id);
        if ($response == '0') {
            throw  new \Exception('fail delete favorite');
        } else {
            return true;
        }

    }
}
