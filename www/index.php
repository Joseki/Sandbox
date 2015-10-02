<?php

// Let bootstrap create Dependency Injection container.
/** @var Nette\DI\Container $container */
$container = require __DIR__ . '/../app/bootstrap.php';

// Run application.
$container->getService('application')->run();
