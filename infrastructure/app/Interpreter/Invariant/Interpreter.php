<?php namespace Infrastructure\App\Interpreter\Invariant;

use App\Interpreter\Context;
use Infrastructure\App\Interpreter\Compare;

class Interpreter implements \App\Interpreter\Interpreter
{    
    private $compare;
    
    public function __construct(Compare\Interpreter $compare)
    {
        $this->compare = $compare;
    }
    
    public function interpret(Context $context)
    { 
        return $this->compare->interpret($context);
    }
}



