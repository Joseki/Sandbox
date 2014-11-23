<?php

namespace MyApplication\Navigation\Navigation;

interface NavigationControlFactory
{
    /**
     * @return NavigationControl
     */
    function create();
}
