<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatchFruitRequest;
use App\Http\Requests\StoreFruitRequest;
use App\Http\Requests\UpdateFruitRequest;
use App\Http\Resources\FruitResource;
use App\Interfaces\FruitRepositoryInterface;

class FruitControllerWithRepository extends Controller
{
    public function __construct(private FruitRepositoryInterface $fruitRepository) {}

    public function index()
    {
        $fruit = $this->fruitRepository->all();

        return FruitResource::collection($fruit);
    }

    public function store(StoreFruitRequest $request)
    {
        $fruit = $this->fruitRepository->create($request->validated());

        return FruitResource::make($fruit);
    }

    public function show(int $id)
    {
        $fruit = $this->fruitRepository->find($id);

        return FruitResource::make($fruit);
    }

    public function update(UpdateFruitRequest $request, int $id)
    {
        $fruit = $this->fruitRepository->update($id, $request->validated());

        return FruitResource::make($fruit);
    }

    public function patch(PatchFruitRequest $request, int $id)
    {
        $fruit = $this->fruitRepository->update($id, $request->validated());

        return FruitResource::make($fruit);
    }

    public function destroy(int $id)
    {
        $this->fruitRepository->delete($id);

        return response()->noContent();
    }
}
