<?php

namespace App\Repositories;

use App\Interfaces\FavoriteRepositoryInterface;
use App\Models\Favorite;
use App\Models\FavoriteList;
use Exception;
use Illuminate\Support\Facades\DB;

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


    public function findByIdUserCount(int $id)
    {
        return DB::table('favorite_lists as l')
            ->join('favorites as f', 'f.id', '=', 'l.id_favorite')
            ->where('f.id_user', $id)
            ->count('l.id');


    }

    public function findId(int $id)
    {
        return Favorite::query()->findOrFail($id);
    }


    public function create(array $data)
    {
        return Favorite::query()->create($data);
    }

    public function addToFavoriteList(array $data)
    {
        return FavoriteList::query()->create($data);
    }


    public function update(int $id, array $data)
    {
//        print_r($data);
        $response = Favorite::query()->where('id', $id)->update($data);
        if ($response == '0') {
            throw new Exception("Fail Update Data $id");
        }
        return true;
    }

    public function removeId(int $id)
    {
        $response = null;
        DB::transaction(function () use ($id) {
            FavoriteList::query()->where('id_favorite', $id)->delete();
            $response = Favorite::query()->where('id', $id)->delete();
        }, 5);
        if ($response == '0') {
            throw  new Exception('fail delete favorite');
        }
        return true;
    }


    public function deleteToFavoriteList(int $id)
    {
        $response = FavoriteList::query()->where('id', $id)->delete();
        if ($response == '0') {
            throw  new Exception('fail delete favorite');
        }

    }
}
