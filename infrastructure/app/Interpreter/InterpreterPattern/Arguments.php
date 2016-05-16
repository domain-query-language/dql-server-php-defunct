<?php namespace Infrastructure\App\Interpreter\InterpreterPattern;

use App\Interpreter\Context;

class Arguments
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
        return $arguments;
    }
}


