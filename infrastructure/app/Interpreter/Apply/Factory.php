<?php namespace Infrastructure\App\Interpreter\Apply;

use Infrastructure\App\Interpreter\Check;
use Infrastructure\App\Interpreter\Arguments;

class Factory 
{   
    private $check_factory;
    
    public function __construct(Check\Factory $check_factory)
    {
        $this->check_factory = $check_factory;
    }
    
    public function ast($ast)
    {
        $arguments_interpreter = new Arguments\Interpreter($ast->arguments);
        
        return new Interpreter($arguments_interpreter);
    }   
}