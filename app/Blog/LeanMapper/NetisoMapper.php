<?php

namespace Blog\LeanMapper;

use Joseki\LeanMapper\Mapper as LMMapper;
use LeanMapper\Row;

class Mapper extends LMMapper
{

    const DEFAULT_PACKAGE_NAMESPACE = 'Blog';

    /** @var string */
    protected $basePackagesNamespace = self::DEFAULT_PACKAGE_NAMESPACE;

    /** @var array */
    private $packages;

    /** @var array */
    private $tables;



    /**
     * @param $packages
     * @param $tables
     */
    public function __construct(array $packages, array $tables)
    {
        $this->packages = $packages;
        $this->tables = $tables;
    }



    /*
     * @inheritdoc
     */
    public function getEntityClass($table, Row $row = null)
    {
        $tablePackage = $this->tables[$table];
        $table = ucfirst($this->underscoreToCamel($table));
        return $this->basePackagesNamespace . '\\' . $tablePackage . '\\' . $table;
    }
}
