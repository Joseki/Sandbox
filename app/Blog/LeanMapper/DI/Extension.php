<?php

namespace Blog\LeanMapper\DI;

use Blog\LeanMapper\Mapper;
use Nette;
use Tracy\Debugger;

class Extension extends Nette\DI\CompilerExtension
{

    public $defaults = [
        'packages' => []
    ];



    public function loadConfiguration()
    {
        $container = $this->getContainerBuilder();
        $config = $this->getConfig($this->defaults);

        $useProfiler = isset($config['profiler'])
            ? $config['profiler']
            : class_exists('Tracy\Debugger') && $container->parameters['debugMode'];
        unset($config['profiler']);

        $packageStruct = $config['packages'];
        unset($config['packages']);

        if (isset($config['flags'])) {
            $flags = 0;
            foreach ((array)$config['flags'] as $flag) {
                $flags |= constant($flag);
            }
            $config['flags'] = $flags;
        }

        $packages=[];
        $tables=[];
        $this->parsePackages($packages, $tables, $packageStruct);

        foreach ($tables as $table => $package) {
            $table = ucfirst($this->underscoreToCamel($table));
            $container->addDefinition($this->prefix($table))
                ->setClass(Mapper::DEFAULT_PACKAGE_NAMESPACE . '\\' . $package . '\\' . $table . 'Repository');
        }

        $container->addDefinition($this->prefix('mapper'))
            ->setClass('Blog\LeanMapper\Mapper', array($packages, $tables));

        $container->addDefinition($this->prefix('entityFactory'))
            ->setClass('LeanMapper\DefaultEntityFactory');

        $connection = $container->addDefinition($this->prefix('connection'))
            ->setClass('LeanMapper\Connection', array($config));

        if ($useProfiler) {
            $panel = $container->addDefinition($this->prefix('panel'))
                ->setClass('Dibi\Bridges\Tracy\Panel');
            $connection->addSetup(array($panel, 'register'), array($connection));
            if (is_array($useProfiler) && isset($useProfiler['file'])) {
                $fileLogger = $container->addDefinition($this->prefix('fileLogger'))
                    ->setClass('Blog\LeanMapper\FileLogger');
                $connection->addSetup(array($fileLogger, 'register'), array($connection, $useProfiler['file']));
            }
        }
    }



    private function underscoreToCamel($s)
    {
        $s = strtolower($s);
        $s = preg_replace('#_(?=[a-z])#', ' ', $s);
        $s = substr(ucwords('x' . $s), 1);
        $s = str_replace(' ', '', $s);
        return $s;
    }



    private function parsePackages(&$packages, &$tables, $data, $package = '')
    {
        foreach ($data as $prefix => $table) {
            if (is_string($table)) {
                if (!isset($packages[$package])) {
                    $packages[$package] = [];
                }
                $packages[$package][] = $table;
                if (array_key_exists($table, $tables)) {
                    throw new \Exception("Multiple packages for table $table found.");
                }
                $tables[$table] = $package;
            } elseif (is_array($table)) {
                $this->parsePackages($packages, $tables, $table, trim("$package\\$prefix", '\\'));
            }
        }
    }

}
