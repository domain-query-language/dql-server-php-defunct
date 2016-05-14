<?php namespace Infrastructure\App\Interpreter\InterpreterPattern;

class Invariant
{
    public function interpret($context)
    {
        $arguments = $context->arguments;
        
        return true;
    }
}

