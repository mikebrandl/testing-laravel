<?php

namespace App\Interfaces;

interface FruitRepositoryInterface
{
    public function all();

    public function find(int $id);

    public function delete(int $id): bool;

    public function create(array $details);

    public function update($id, array $details);
}
