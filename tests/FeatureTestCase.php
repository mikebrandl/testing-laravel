<?php

namespace Tests;

use Illuminate\Support\Facades\Artisan;

abstract class FeatureTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh');
    }
}
