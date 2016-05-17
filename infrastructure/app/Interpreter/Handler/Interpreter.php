<?php namespace Infrastructure\App\Interpreter\Handler;

use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{
    private $statements = [];
    
    public function __construct($statements)
    {
        $this->statements = $statements;
    }
        
    public function interpret(Context $context)
    {
        $this->context = $context;
        $events = [];
        foreach ($this->statements as $statement) {
           $events[] = $statement->interpret($context); 
        }  
        return array_values(array_filter($events));
    }
}