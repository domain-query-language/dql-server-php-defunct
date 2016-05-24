<?php namespace Infrastructure\App\Interpreter\Check;

use App\Interpreter\Context;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $compare;
    
    public function __construct($compare)
    {
        $this->compare = $compare;
    }
    
    public function interpret(Context $context)
    { 
        return $this->compare->interpret($context);
    }
}



