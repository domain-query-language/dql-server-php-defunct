<?php namespace Infrastructure\App\Interpreter\Invariant;

use Infrastructure\App\Interpreter\Compare;

class Factory 
{     
    private $compare_factory;
    
    public function __construct(Compare\Factory $compare_factory)
    {
        $this->compare_factory = $compare_factory;
    }
    
    public function ast($ast)
    {
        $check = $this->compare_factory->ast($ast->check->condition);
        return new Interpreter($check);
    }
}



