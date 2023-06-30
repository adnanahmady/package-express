<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Support\Traits\AssertionsTrait;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use AssertionsTrait;
}
