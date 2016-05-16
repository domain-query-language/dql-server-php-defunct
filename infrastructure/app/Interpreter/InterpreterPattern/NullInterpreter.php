<?php namespace Infrastructure\App\Interpreter\InterpreterPattern;

use App\Interpreter\Context;

class NullInterpreter
{
    public function interpret(Context $context)
    {
        return true;
    }
}
