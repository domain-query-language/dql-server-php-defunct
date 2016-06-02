<?php namespace App\Interpreter;

use App\Interpreter\Context;

class NullInterpreter implements \App\Interpreter\Interpreter
{
    public function interpret(Context $context)
    {
        return $context;
    }
}
