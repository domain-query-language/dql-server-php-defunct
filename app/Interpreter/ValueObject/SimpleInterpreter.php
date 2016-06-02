<?php namespace App\Interpreter\ValueObject;

use App\Interpreter\Context;

class SimpleInterpreter implements \App\Interpreter\Interpreter
{    
    private $check;
    
    public function __construct($check)
    {
        $this->check = $check;
    }
    
    public function interpret(Context $context)
    { 
        if (!$this->check->interpret($context)) {
            throw new Exception();
        }
        return $context->get_property('value');
    }
}



