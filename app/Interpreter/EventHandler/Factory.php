<?php namespace App\Interpreter\EventHandler;

class Factory
{    
    public function ast($ast)
    {
        if (!isset($ast->statements)) {
            return new NullInterpreter();
        }
        return new Interpreter($ast->statements);
    }
}

