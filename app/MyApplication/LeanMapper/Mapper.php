<?php

namespace MyApplication\LeanMapper;

use Joseki\LeanMapper\PackageMapper;

class Mapper extends PackageMapper
{

    const DEFAULT_PACKAGE_NAMESPACE = 'MyApplication';

    /** @var string */
    protected $basePackagesNamespace = self::DEFAULT_PACKAGE_NAMESPACE;

}
