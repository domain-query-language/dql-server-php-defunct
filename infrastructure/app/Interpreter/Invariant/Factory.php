<?php namespace Infrastructure\App\Interpreter\Invariant;

use Infrastructure\App\Interpreter\Check;

class Factory 
{     
    private $check_factory;
    
    public function __construct(Check\Factory $check_factory)
    {
        $this->check_factory = $check_factory;
    }
    
    public function ast($ast)
    {
        $check = $this->check_factory->ast($ast->check);
        return new Interpreter($check);
    }
}



