<?php namespace Infrastructure\App\Interpreter\Arguments;

use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $ast;
    
    public function __construct($ast)
    {
        $this->ast = $ast;
    }
    
    public function interpret(Context $context)
    {
        $arguments = [];
        foreach ($this->ast as $argument_ast) {
            $arguments[] = $context->get_property($argument_ast->property);
        }
        return $context;
    }
}




