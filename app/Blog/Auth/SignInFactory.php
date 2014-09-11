<?php

namespace Blog\Auth;

interface SignFormFactory
{
    /**
     * @return \Blog\Auth\SignForm
     */
    function create();
} 
