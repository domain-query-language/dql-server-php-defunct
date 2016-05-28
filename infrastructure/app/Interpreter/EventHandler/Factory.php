<?php namespace Infrastructure\App\Interpreter\EventHandler;

class Factory
{    
    public function ast($ast)
    {
        dd($ast);
        return new Interpreter();
    }
}

