<?php

namespace Tests\Feature;

use App\Interfaces\FruitRepositoryInterface;
use App\Models\Fruit;
use App\Repositories\FruitRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Mockery\MockInterface;
use Tests\FeatureTestCase;

class RepositoryFruitTest extends FeatureTestCase
{
    private FruitRepository|MockInterface|FruitRepositoryInterface $fruitRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->fruitRepository = Mockery::mock(FruitRepositoryInterface::class);
    }

    public function testFruitIndex(): void
    {
        $response = [Fruit::factory()->make(['name' => 'MIKE BRANDL', 'id' => 1]), Fruit::factory()->make(['name' => 'MIKE BRANDL', 'id' => 2])];
        $this->fruitRepository->shouldReceive('all')->once()->andReturn($response);
        $this->app->instance(FruitRepositoryInterface::class, $this->fruitRepository);
        $this->getJson('/repo/fruit')->assertSuccessful();
    }

    public function testShowFruit(): void
    {
        $response = Fruit::factory()->make(['name' => 'MIKE BRANDL', 'id' => 1]);
        $this->fruitRepository->shouldReceive('find')->once()->andReturn($response);
        $this->app->instance(FruitRepositoryInterface::class, $this->fruitRepository);
        $this->getJson('/repo/fruit/1')->assertSuccessful();
    }

    public function testResourceReturnsOnlyName(): void
    {
        $response = Fruit::factory()->make(['name' => 'MIKE BRANDL', 'id' => 1]);
        $this->fruitRepository->shouldReceive('find')->once()->andReturn($response);
        $this->app->instance(FruitRepositoryInterface::class, $this->fruitRepository);

        $this->getJson('/repo/fruit/1')
            ->assertSuccessful()
            ->assertExactJson(['data' => ['name' => 'MIKE BRANDL']]);
    }

    public function testShowFruitFails(): void
    {
        $this->fruitRepository->shouldReceive('find')->once()->andThrow(ModelNotFoundException::class);
        $this->app->instance(FruitRepositoryInterface::class, $this->fruitRepository);
        $this->getJson('/repo/fruit/999')->assertNotFound();
    }

    public function testCreateFruit(): void
    {
        $response = Fruit::factory()->make(['name' => 'MIKE BRANDL', 'id' => 1]);
        $this->fruitRepository->shouldReceive('create')->once()->andReturn($response);
        $this->app->instance(FruitRepositoryInterface::class, $this->fruitRepository);
        $this->postJson('/repo/fruit', $response->toArray())->assertSuccessful();
    }

    public function testCreateFruitFailsWithNoData(): void
    {
        $this->postJson('/repo/fruit', [])
            ->assertJsonValidationErrors(['name', 'color']);
    }

    public function testUpdateFruit(): void
    {
        $response = Fruit::factory()->make(['name' => 'JODIE BRANDL', 'id' => 1]);
        $this->fruitRepository->shouldReceive('update')->once()->andReturn($response);
        $this->app->instance(FruitRepositoryInterface::class, $this->fruitRepository);
        $this->putJson('/repo/fruit/1', $response->toArray())->assertSuccessful();
    }

    public function testUpdateFruitRequiresAllFields(): void
    {
        $this->putJson('/repo/fruit/1', [])
            ->assertJsonValidationErrors(['name', 'color']);
    }

    public function testPatchFruit(): void
    {
        $response = Fruit::factory()->make(['name' => 'JODIE BRANDL', 'id' => 1]);
        $this->fruitRepository->shouldReceive('update')->once()->andReturn($response);
        $this->app->instance(FruitRepositoryInterface::class, $this->fruitRepository);
        $this->patchJson('/repo/fruit/1', [])
            ->assertSuccessful();
    }

    public function testDeleteFruit(): void
    {
        $this->fruitRepository->shouldReceive('delete')->once()->andReturn(true);
        $this->app->instance(FruitRepositoryInterface::class, $this->fruitRepository);
        $this->deleteJson('/repo/fruit/1')
            ->assertSuccessful();
    }
}
