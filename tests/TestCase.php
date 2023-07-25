<?php

namespace Tests;

use Tests\SendGraphQLRequest;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use SendGraphQLRequest;
}
