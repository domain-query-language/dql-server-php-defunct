<?php namespace App\Interpreter\Handler\Statement;

use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $interpreter;
    
    public function __construct($interperter)
    {
        $this->interpreter = $interperter;
    }
    
    public function interpret(Context $context)
    {
        return $this->interpreter->interpret($context);
    }
}

