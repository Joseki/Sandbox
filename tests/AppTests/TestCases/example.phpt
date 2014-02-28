<?php

use Tester\Assert;

$container = require __DIR__ . '/../bootstrap.php';

class ExampleTest extends Tester\TestCase
{


	function setUp()
	{
	}

	function testExample()
	{
		$foo = TRUE;
		Assert::same(TRUE, $foo);
	}

}

id(new ExampleTest($container))->run();
