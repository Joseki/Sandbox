<?php

namespace MyApplication\Auth\SignIn;

interface SignInControlFactory
{
    /**
     * @return \MyApplication\Auth\SignIn\SignInControl
     */
    function create();
} 
