<?php


namespace MyApplication\Navigation;

interface NavigationFactory
{
    /**
     * @return \MyApplication\Navigation\Navigation
     */
    function create();
}
