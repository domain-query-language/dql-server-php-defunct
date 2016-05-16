<?php namespace Infrastructure\App\Interpreter\InterpreterPattern;

use App\Interpreter\Context;

class NullInterpreter implements \App\Interpreter\Interpreter
{
    public function interpret(Context $context)
    {
        return true;
    }
}
