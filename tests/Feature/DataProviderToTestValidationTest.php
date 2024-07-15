<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\FeatureTestCase;

class DataProviderToTestValidationTest extends FeatureTestCase
{
    #[DataProvider('provideCreationData')]
    public function testCreateFruit($data, $code): void
    {
        $this->postJson('/fruit', $data)
            ->assertStatus($code);
    }

    /**
     * @return string[][]
     */
    public static function provideCreationData()
    {
        return [
            'valid_data' => [
                /**
                 * You can use factories in unit tests like the below.
                 * This is because you can't use faker in a unit test.
                 * This is because the framework hasn't booted in a unit test, that's why it's faster.
                 * Fruit::factory()->make()->toArray()
                 * So... we have to manually specify the data.
                 */
                ['name' => 'apple', 'color' => 'red'],
                201,
            ],
            'invalid_data' => [
                ['name' => 'banana', 'colour' => 'yellow'],
                422,
            ],
        ];
    }
}
