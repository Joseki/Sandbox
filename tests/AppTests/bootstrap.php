<?php

if (!$autoload = @include __DIR__ . '/../../libs/composer/autoload.php') {
    echo 'Install Nette Tester using `composer update --dev`';
    exit(1);
}
$autoload->add('JosekiTests', __DIR__ . '/..');

// configure environment
Tester\Environment::setup();
date_default_timezone_set('Europe/Prague');

// create temporary directory
define('TEMP_DIR', __DIR__ . '/../temp/' . (isset($_SERVER['argv']) ? md5(serialize($_SERVER['argv'])) : getmypid()));
Tester\Helpers::purge(TEMP_DIR);

$_SERVER = array_intersect_key(
    $_SERVER,
    array_flip(['PHP_SELF', 'SCRIPT_NAME', 'SERVER_ADDR', 'SERVER_SOFTWARE', 'HTTP_HOST', 'DOCUMENT_ROOT', 'OS', 'argc', 'argv'])
);
$_SERVER['REQUEST_TIME'] = 1234567890;
$_ENV = $_GET = $_POST = array();

if (extension_loaded('xdebug')) {
    xdebug_disable();
    Tester\CodeCoverage\Collector::start(__DIR__ . '/coverage.dat');
}

function id($val)
{
    return $val;
}

function run(Tester\TestCase $testCase)
{
    $testCase->run(isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : null);
}
