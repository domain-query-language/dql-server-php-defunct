<?php

namespace App\Interpreter;

interface Interpreter 
{
    public function interpret(Context $context);
}

