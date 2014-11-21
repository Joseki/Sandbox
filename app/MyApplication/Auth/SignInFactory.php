<?php

namespace MyApplication\Auth;

interface SignFormFactory
{
    /**
     * @return \MyApplication\Auth\SignForm
     */
    function create();
} 
