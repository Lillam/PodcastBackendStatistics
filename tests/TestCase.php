<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Globally setting this for the sake of being able to unit test and feature test without the need of dataProviders.
     * this is something that could be utilised at a future point and potentially a point of improvement for simpler and
     * more concise testing.
     *
     * @return bool
     */
    public function usesDataProvider(): bool
    {
        return false;
    }
}
