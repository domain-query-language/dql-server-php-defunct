<?php namespace Infrastructure\App\Interpreter\Invariant;

class Factory 
{     
    public function __construct()
    {

    }
    
    public function ast($ast)
    {
        return new Interpreter($ast);
    }
}



