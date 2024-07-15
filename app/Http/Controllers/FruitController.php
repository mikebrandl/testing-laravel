<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatchFruitRequest;
use App\Http\Requests\StoreFruitRequest;
use App\Http\Requests\UpdateFruitRequest;
use App\Http\Resources\FruitResource;
use App\Models\Fruit;

class FruitController extends Controller
{
    public function index()
    {
        $fruit = Fruit::all();

        return FruitResource::collection($fruit);
    }

    public function store(StoreFruitRequest $request)
    {
        $fruit = Fruit::create($request->validated());

        return FruitResource::make($fruit);
    }

    public function show(Fruit $fruit)
    {
        return FruitResource::make($fruit);
    }

    public function update(UpdateFruitRequest $request, Fruit $fruit)
    {
        $fruit->update($request->validated());

        return FruitResource::make($fruit);
    }

    public function patch(PatchFruitRequest $request, Fruit $fruit)
    {
        $fruit->update($request->validated());

        return FruitResource::make($fruit);
    }

    public function destroy(Fruit $fruit)
    {
        $fruit->delete();

        return response()->noContent();
    }
}
