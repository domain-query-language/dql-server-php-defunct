<?php namespace Infrastructure\App\Interpreter\InterpreterPattern;

use Infrastructure\App\Interpreter\InterpreterPattern\Handler;
use App\Interpreter\Context;

class CommandHandler implements \App\Interpreter\Interpreter
{
    private $interpreter;
    
    public function __construct(Handler\Factory $handler_factory, $ast)
    {
        $this->interpreter = $handler_factory->ast($ast);
    }
        
    public function interpret(Context $context)
    {
        return $this->interpreter->interpret($context);
    }
}