<?php

namespace Joseki\Application\DI;

use Nette;

class ErrorPresenterExtension extends Nette\DI\CompilerExtension
{

    public $defaults = [
        'version' => null
    ];



    public function loadConfiguration()
    {
        $container = $this->getContainerBuilder();
        $config = $this->getConfig($this->defaults);

        $container->addDefinition($this->prefix('factory'))
            ->setClass('Joseki\Application\ErrorPresenterFactory')
            ->addSetup('setVersion', array($config['version']));
    }



    public function afterCompile(Nette\PhpGenerator\ClassType $class)
    {
        $initialize = $class->methods['initialize'];

        $initialize->addBody(
            '$this->getService(?)->setDefaultErrorPresenter($this->getService(?)->errorPresenter);',
            array($this->prefix('factory'), 'application')
        );

        $initialize->addBody(
            '$this->getService(?)->errorPresenter = $this->getService(?)->getErrorPresenter();',
            array('application', $this->prefix('factory'))
        );
    }

}
