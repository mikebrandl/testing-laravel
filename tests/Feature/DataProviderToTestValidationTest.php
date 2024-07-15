<?php

namespace Tests\Feature;

use App\Models\Fruit;
use Tests\FeatureTestCase;

class DataProviderToTestValidationTest extends FeatureTestCase
{
    /**
     * @dataProvider provideCreationData
     */
    public function testCreateFruit($data, $code): void
    {
        $this->postJson('/fruit', $data)->assertStatus($code);
    }

    /**
     * @return string[][]
     */
    public static function provideCreationData()
    {
        return [
            [
                // Fruit::factory()->make()->toArray(), -- This doesn't work in a unit test, so we have to manually specify the data.
                ['name' => 'apple', 'color' => 'red'],
                201,
            ],
            [
                ['name' => 'banana'],
                422,
            ],
        ];
    }
}
