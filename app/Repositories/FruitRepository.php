<?php

namespace App\Repositories;

use App\Interfaces\FruitRepositoryInterface;
use App\Models\Fruit;

class FruitRepository implements FruitRepositoryInterface
{
    public function find(int $id)
    {
        return Fruit::findOrFail($id);
    }

    public function all()
    {
        return Fruit::all();
    }

    public function delete(int $id): bool
    {
        return Fruit::whereId($id)->delete();
    }

    public function create(array $details)
    {
        return Fruit::create($details);
    }

    public function update($id, array $details)
    {
        return Fruit::whereId($id)->update($details);
    }
}
