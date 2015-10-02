<?php

namespace AppTests;

use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

class ExampleTest extends TestCase
{
    public function testSample()
    {
        Assert::true(true);
    }
}

\run(new ExampleTest());
