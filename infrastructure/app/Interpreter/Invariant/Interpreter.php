<?php namespace Infrastructure\App\Interpreter\Invariant;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\Check;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $check;
    
    public function __construct(Check\Interpreter $check)
    {
        $this->check = $check;
    }
    
    public function interpret(Context $context)
    { 
        return $this->check->interpret($context);
    }
}



