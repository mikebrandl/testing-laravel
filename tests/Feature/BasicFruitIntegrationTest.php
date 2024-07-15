<?php

namespace Tests\Feature;

use App\Models\Fruit;
use Tests\FeatureTestCase;

class BasicFruitIntegrationTest extends FeatureTestCase
{
    public function testFruitIndex(): void
    {
        $this->getJson('/fruit')->assertSuccessful();
    }

    public function testShowFruit(): void
    {
        $fruit = Fruit::factory()->create();
        $this->getJson('/fruit/'.$fruit->id)->assertSuccessful();
    }

    public function testResourceReturnsOnlyName(): void
    {
        $fruit = Fruit::factory()->create();
        $this->getJson('/fruit/'.$fruit->id)
            ->assertSuccessful()
            ->assertExactJson(['data' => ['name' => $fruit->name]]);
    }

    public function testShowFruitFails(): void
    {
        $this->getJson('/fruit/999')->assertNotFound();
    }

    public function testCreateFruit(): void
    {
        $data = Fruit::factory()->make()->toArray();
        $this->postJson('/fruit', $data)->assertSuccessful();
    }

    public function testCreateFruitFailsWithNoData(): void
    {
        $this->postJson('/fruit', [])
            ->assertJsonValidationErrors(['name', 'color']);
    }

    public function testUpdateFruit(): void
    {
        $fruit = Fruit::factory()->create();
        $data = Fruit::factory()->make()->toArray();
        $this->putJson('/fruit/'.$fruit->id, $data)->assertSuccessful();
        $this->assertDatabaseHas('fruits', $data);
    }

    public function testUpdateFruitRequiresAllFields(): void
    {
        $fruit = Fruit::factory()->create();
        $this->putJson('/fruit/'.$fruit->id, [])
            ->assertJsonValidationErrors(['name', 'color']);
    }

    public function testPatchFruit(): void
    {
        $fruit = Fruit::factory()->create();
        $this->patchJson('/fruit/'.$fruit->id, [])
            ->assertSuccessful();
    }

    public function testPatchFruitActuallyUpdatesData(): void
    {
        $fruit = Fruit::factory()->create(['name' => 'apple', 'color' => 'red']);
        $data = ['name' => 'testing'];
        $this->patchJson('/fruit/'.$fruit->id, $data)
            ->assertSuccessful();
        $this->assertDatabaseHas('fruits', ['name' => 'testing', 'color' => 'red']);
    }

    public function testDeleteFruit(): void
    {
        $fruit = Fruit::factory()->create();
        $this->deleteJson('/fruit/'.$fruit->id)
            ->assertSuccessful();
        $this->assertModelMissing($fruit);
    }
}
