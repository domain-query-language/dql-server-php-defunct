<?php namespace Infrastructure\App\Interpreter\EventHandler;

class Factory
{    
    public function ast($ast)
    {
        return new Interpreter();
    }
}

