<?php


namespace Blog\Navigation;

interface NavigationFactory
{
    /**
     * @return \Blog\Navigation\Navigation
     */
    function create();
}
